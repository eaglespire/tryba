<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Card;
use App\Services\ModulrService;
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;

class IVRService {

  protected $document;
  protected $banking;
  protected $card;
  protected $user;
  protected $transaction;
  protected $invoice;
  protected $modulrService;
  protected $twilio;

  public function __construct(User $user, ModulrService $modulrService, VoiceResponse $twilio) {
    $this->modulrService = $modulrService;
    $this->clientID = \env('TC_CID');
    $this->clientSecret = \env('TC_CSEC');
    $this->TC_APIKEY = \env('TC_APIKEY');
    $this->TC_PUBKEY = \env('TC_PUBKEY');
    $this->url = \env('TC_URL');
    $this->account_sid = \env('TWILIO_SID');
    $this->auth_token = \env('TWILIO_AUTH_TOKEN');
    $this->twilio_number = \env('TWILIO_NUMBER');
    $this->authToken = base64_encode($this->clientID . ':' . $this->clientSecret);
    $this->$twilio = $twilio;

}

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function showWelcome()
    {
        $response = new VoiceResponse();
        $gather = $response->gather(
            [
                'numDigits' => 1,
                'action' => route('ivr.menu', [], false)
            ]
        );

        $gather->play(asset("voice/welcome1.mp3"));
        
        $response->redirect(route('ivr.welcome', [], false));
        return $response;
    }

    /**
     * Responds to selection of an option by the caller
     *
     * @return \Illuminate\Http\Response
     */
    public function ivrMenu($request)
    {
        // \Log::info(array($request));
        $selectedOption = $request->input('Digits');
        $response = new VoiceResponse();

        switch ($selectedOption) {
            case 1:
                return $this->_cardsMenu();
            case 2:
                return $this->openAccount($request);
            case 3:
                return $this->otherEnquiriesContactInfo($request, 'account-balance'); 
            case 4:
                return $this->otherEnquiriesContactInfo($request, 'report-fraud'); 
            case 0:
                return $this->otherEnquiriesContactInfo($request, 'speak-to-cs');
            case 9:
                $response->redirect(route('ivr.welcome', [], false));
                return $response;
        
            }

        $response->play(asset("voice/invalidoption.mp3"));
        
        $response->redirect(route('ivr.welcome', [], false));

        return $response;
    }

    private function _cardsMenu()
    {
        $response = new VoiceResponse();
        $gather = $response->gather(
            ['numDigits' => '1', 'action' => route('ivr.card.operations', [], false)]
        );
        // $gather->say("If would like to block  your card, please press 1. For any other issue concerning your card please press 2",
        // ['voice' => 'Alice', 'language' => 'en-GB']);
        $gather->play(asset("voice/cardmenu.mp3"));
        // $this->_cardsMenu();

        return $response;
    }

    public function cardOperations($request)
    {
        $cardAction = [
            '1' => 'ivr.get.phone',
            '2' => 'ivr.contact.info'
        ];
        
        $response = new VoiceResponse();
        $selectedOption = $request->input('Digits');
        // \Log::info(json_encode($selectedOption));
        $optionExists = isset($cardAction[$selectedOption]);
        if ($optionExists) {
            $url = $cardAction[$selectedOption];
            $response->redirect(route($url, [], false));
            return $response;
        } else {
            $errorResponse = new VoiceResponse();
            // $errorResponse->say(
            //     'Sorry, you selected an invalid option. Returning to the main menu',
            //     ['voice' => 'Alice', 'language' => 'en-GB']
            // );
            $errorResponse->play(asset("voice/invalidoption.mp3"));
            $errorResponse->redirect(route('ivr.welcome', [], false));
            return $errorResponse;
        }

    }

    public function getNumber($request)
    {
        $response = new VoiceResponse();
        $gather = $response->gather(
            ['numDigits' => '11', 'action' => route('ivr.verify.phone', [], false)]
        );
        // $gather->say(
        //     'Please enter the phone number registered with your tribal account',
        //     ['voice' => 'Alice', 'language' => 'en-GB']
        // );
        $gather->play(asset("voice/enterphone.mp3"));
        $response->redirect(route('ivr.get.phone', [], false));
        return $response;
    }

    public function verifyNumber($request)
    {
        $response = new VoiceResponse();
        $phoneNumber = $request->input('Digits');

        $user = User::where('phone', '+44'.substr($phoneNumber, -10))->first();

        if ($user) {
            $response->redirect(route('ivr.get.pin', ['phone'=>$phoneNumber], false));
            return $response;
        } else {
            $errorResponse = new VoiceResponse();
            $errorResponse->play(asset("voice/phonenotlinked.mp3"));
            $errorResponse->redirect(route('ivr.get.phone', [], false));
            return $errorResponse;
        }

    }

    public function getPin($phone)
    {
        $response = new VoiceResponse();
        $gather = $response->gather(
            ['numDigits' => '4', 'action' => route('ivr.verify.pin', ['phone'=>$phone], false)]
        );
        $gather->play(asset("voice/enterpin.mp3"));
       $response->redirect(route('ivr.get.pin', ['phone'=>$phone], false));

        return $response;
    }

    public function verifyPinAndBlockCard($request, $phone)
    {
        if (isset($phone) && !empty($phone)) {
            $user = User::where('phone', '+44'.substr($phone, -10))->first();
            $card = Card::where('user_id', $user['id'])->where('type', 'virtual')->where('c_status', 'ACTIVE')->first();
            if($card && !empty($card)){
            $response = new VoiceResponse();
                $pin = $request->input('Digits');
                $pinResp =  $this->modulrService->retrievePin($card['c_id']);
                if ($pinResp && $pin == $pinResp->pin) {
                    $blockResp =  $this->modulrService->blockOrUnblockCard($card['c_id'], 'block');
                    if(isset($blockResp) && $blockResp == true){
                        $response->say(
                            'Your card has been blocked successfully.',
                            ['voice' => 'Alice', 'language' => 'en-GB']
                        );
                        $response->play(asset("voice/goodbye.mp3"));
                        return $response;
                    } else {
                        $errorResponse = new VoiceResponse();
                        // $errorResponse->say(
                        //     'Sorry, we are unable to block your card at the moment.  Please try again, or write to customer support, at support@tribal.io.',
                        //     ['voice' => 'Alice', 'language' => 'en-GB']
                        // );
                        $errorResponse->play(asset("voice/writesupport.mp3"));
                        redirect(route('ivr.menu', [], false));
                        return $errorResponse;
                    }
                } else {
                    $errorResponse1 = new VoiceResponse();
                    $errorResponse1->say(
                        'Sorry, The Pin you entered is incorrect.',
                        ['voice' => 'Alice', 'language' => 'en-GB']
                    );
                    
                    $errorResponse1->redirect(route('ivr.get.pin', ['phone'=>$phone], false));
                    return $errorResponse1;
                }
             } else { //No card found
                $errorResponse2 = new VoiceResponse();
                $errorResponse2->say(
                    'Sorry, There is no active card linked to your account. Returning to main menu',
                    ['voice' => 'Alice', 'language' => 'en-GB']
                );
                $errorResponse2->redirect(route('ivr.welcome', [], false));
                return $errorResponse2;
            }
        }
        else { //No seesion with phone number found
            $errorResponse3 = new VoiceResponse();
            $errorResponse3->say(
                'Sorry, There is no active debit card linked to your account.',
                ['voice' => 'Alice', 'language' => 'en-GB']
            );
            $errorResponse3->redirect(route('ivr.get.phone', [], false));
            return $errorResponse3;
        }
    }

     /**
     * Responds with a <Dial> to the caller's planet
     *
     * @return \Illuminate\Http\Response
     */
    public function openAccount($request)
    {
        $to = $request['Caller'];
        $response = new VoiceResponse();
        $response->play(asset("voice/openaccount.mp3"));
        $response->play(asset("voice/goodbye.mp3"));

        $this->SendSMS($to, 'Thank you for getting in touch. We are super excited to learn you want to be a tryba customer. To begin, visit www.tryba.io and click on Open an Account, or alternatively download the iOS or Android application by visiting the app store.');
        $response->hangup();
        return $response;

    }


    /**
     * Responds with a <Dial> to the caller's planet
     *
     * @return \Illuminate\Http\Response
     */
    public function otherEnquiriesContactInfo($request, $action='none')
    {
        $to = $request['Caller'];
        $response = new VoiceResponse();
        // $response->say(
        //     "You have selected an option that requires contacting support.
        //     An SMS has been sent with additional details to contact our support",
        //     ['voice' => 'Alice', 'language' => 'en-GB']
        // );
        $response->play(asset("voice/contactdetails.mp3"));
        $response->play(asset("voice/goodbye.mp3"));

        $this->SendSMS($to, 'You can chat us on whatsapp, or reach our helpdesk on helpdesk.tryba.io or send an email to support@tryba.io');
        $response->hangup();
        return $response;

    }

    private function SendSMS($to, $msg){
        $client = new Client($this->account_sid, $this->auth_token);
        $client->messages->create(
            $to,
            array(
                'from' => $this->twilio_number,
                'body' => $msg
            )
        );

    }

    public function demo(){
        $response = new VoiceResponse;
        $response->play("https://demo.twilio.com/docs/classic.mp3");

        $response->redirect(route('ivr.music', [], false));

        return $response;
    }
}

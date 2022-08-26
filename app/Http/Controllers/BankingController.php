<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Services\ModulrService;
use App\Notifications\OTP;
use App\Models\Card;
use App\Models\Transactions;
use App\Http\Requests\CardRequest;
use App\Http\Requests\API\CardRequest as CardRequestAPI;
use App\Http\Requests\API\AddBeneficiaryRequest;
use App\Http\Requests\API\OtpRequest;
use PDF;
use App\Http\Requests\PaymentRequest;
use App\Jobs\EmailVerificationJob;


class BankingController extends Controller
{
    protected $user;
    protected $service;
    protected $transaction;

    public function __construct(User $user, ModulrService $service, Transactions $transaction) {
        $this->user = $user;
        $this->service = $service;
        $this->transaction = $transaction;
    }

    public function index() {
        return view('user.banking.index')->withTitle('Tryba Banking');
    }


    /**
     * Create customer
    */
    public function createCustomer(Request $request) {
        $customer = $this->service->createCustomer($request);
        if($customer) {
            return \response()->json([
                'status' => true,
                'message' => 'Customer created',
                'data' => $customer
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Could not create customer',
            'data' => []
        ], 422);
    }

    /**
     * Create benficiary
    */
    public function createBeneficiary(AddBeneficiaryRequest $request) {
        $response = $this->service->createBeneficiary($request);
        if(is_object($response) && !empty($response)) {
            \Log::info($response);
            return \response()->json([
                'status' => true,
                'message' => 'Beneficiary created',
                'data' => json_decode($response)
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => $response,
            'data' => []
        ], 422);
    }

    /**
     * Create get Beneficiaries
    */
    public function getBeneficiaries($customerId, $uid) {
        $user = auth()->guard('user')->user();
        $response = $this->service->getBeneficiaries($customerId, $uid);
        if(is_array($response) && !empty($response)) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $response
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => $response,
            'data' => []
        ], 422);
    }

    /**
     * Get customer accountss
    */
    public function getAccountsByCustomer($customerID) {
        $response = $this->service->getAccountsByCustomer($customerID);
        if(is_array($response) && !empty($response)) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $response
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => $response,
            'data' => []
        ], 422);
    }

    /**
     * Create card
    */
    public function createCard(CardRequest $request) {
        // return $request->all();
        $card = $this->service->createCard($request);
        if($card) {
            return back()->withSuccess("Your $request->card_type Card was created successfully");
        }
        else {
            return back()->withErrors("Could not create card");
        }
    }

    /**
     * Create card via api
    */
    public function createCardAjax(CardRequestAPI $request) {
        $card = $this->service->createCard($request);
        if($card) {
            return \response()->json([
                'status' => true,
                'message' => 'Card created',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Could not create Card',
            'data' => []
        ], 422);
    }

    /**
     * Create physical card
    */
    public function createPhysicalCard(Request $request) {
        $card = $this->service->createPhysicalCard($request);
        if($card) {
            return \response()->json([
                'status' => true,
                'message' => 'Your card request has been submitted',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Could not submit card request',
            'data' => []
        ], 422);
    }

    /**
     * Activate card
    */
    public function activateCard($card_id) {
        $card = $this->service->activateCard($card_id);
        if($card) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Get card
    */
    public function getCard($card_id) {
        $card = $this->service->getCard($card_id);
        if($card) {
            $card->pin = $this->service->retrievePin($card_id);
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Get Pin
    */
    public function retrievePin($card_id) {
        $card = $this->service->retrievePin($card_id);
        if($card) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Block/Unblock card
    */
    public function blockOrUnblock($card_id, $action) {
        $card = $this->service->blockOrUnblockCard($card_id, $action);
        if($card) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $card
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Get account
    */
    public function getAccount($uid) {
        // \Log::info($encodedSignature);
        $account = $this->service->getAccount($uid);
        if($account) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $account
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Get accounts
    */
    public function getAccounts($uid) {
        $account = $this->service->getAccounts($uid);
        if($account) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $account
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Not found',
            'data' => []
        ], 422);
    }

    /**
     * Create card
    */
    public function createPayment(PaymentRequest $request) {
        // \Log::info($request->all());
        $payment = $this->service->createPayment($request);
        if(!$payment) {
            return \response()->json([
                'status' => false,
                'message' => 'Could not create Payment',
                'data' => []
            ], 422);
        }
        if($payment === "error") {
            return \response()->json([
                'status' => false,
                'message' => $payment->message,
                'data' => []
            ], 422);
        }
        $this->transaction->create([
            'user_id'      => $request->user_id,
            'reference'    => $payment->details->reference,
            'currency'     => 19,
            'receiver_id'  => $request->user_id,
            'amount'       => $payment->details->amount,
            'type'         => 9,
            'ref_id'       => $payment->details->externalReference,
            'trans_status' => $payment->status,
        ]);
        return \response()->json([
            'status' => true,
            'message' => 'Payment created',
            'data' => $payment
        ], 200);
    }

    /**
     * Verify Payee
    */
    public function payeeVerification(Request $request) {
        $result = $this->service->payeeVerification($request);
        if($result) {
            return \response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $result
            ], 200);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Could not verify payee',
            'data' => []
        ], 422);
    }

    /**
     * Get fetch user data by user id
     * @var $id
    */
    public function findById($id) {
        $user = $this->user->find($id);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Send Otp
    */
    public function otpVerification(OtpRequest $request) {
        \Log::info($request->all());
        $otp = mt_rand(111111, 999999);
        $user = $this->user->find($request->userId);
        if($user && $request->type === 'send') {
            $user->update(['otp' => $otp]);
            $user->notify(new OTP($otp));
            return \response()->json([
                'status' => true,
                'message' => 'Otp Sent',
                'data' => []
            ], 200);
        }
        elseif($user && $request->type === 'verification') {
            if($user->otp === trim($request->otp)) {
                return \response()->json([
                    'status' => true,
                    'message' => 'Otp Verified',
                    'data' => []
                ], 200);
            }
            return \response()->json([
                'status' => false,
                'message' => 'Invalid code',
                'data' => []
            ], 422);
        }
        return \response()->json([
            'status' => false,
            'message' => 'Could not verify OTP',
            'data' => []
        ], 422);
    }

    /**
     * Payee CoP verification
     */
    public function copVerification($param) {
        return $this->service->getAccessgroups($param);
    }

    public function passwordVerification(Request $request) {
        $user = $this->user->find($request->userId);
        // \Log::info($user);
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 422);
        }
        if(!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid password entered',
            ], 422);
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
        ], 200);
    }

    /**
     * fetch open banking institutions
     */
    public function getInstitutions(Request $request) {
        return $this->service->getInstitutions($request);
        // $data =  $this->service->getInstitutions();
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Could not fetch data',
                'data' => []
            ], 422);
        }
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Get payment service providers for standing order
     */
    public function getPaymentServiceProvider() {
        $data = $this->service->getAccountServicingPaymentProviders();
        if($data) {
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data'  => $data,
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Could not fetch data',
            'data'  => [],
        ], 422);
    }

    /**
     * Open banking
     */
    public function openBanking(Request $request) {
        return $this->service->openBanking($request);
    }

    public function createSecureCardDetailsToken($id) {
        // return config("settings.MODULR.KEY");
        return $this->service->createSecureCardDetailsToken($id);
    }

    /**
     * Generate account statement
     */
    public function generateStatement() {
        $data = [
            "name" => "Peter Andrew",
            "date" => date('m/d/Y'),
            "title" => "Transaction Receipt"
        ];
        $pdf = PDF::loadView('user.account.transaction-statement', $data);
        return $pdf->download('statement.pdf');
        // return view('user.account.statement', $data);
    }

    /**
     * Generate transaction invoice
     */
    public function generateTransactionStatement($id) {
        // $data = [
        //     "name" => "Peter Andrew",
        //     "date" => date('m/d/Y'),
        //     "title" => "Transaction Receipt"
        // ];
        $data = Transactions::find($id);
        $pdf = PDF::loadView('user.account.transaction-statement', $data);
        return $pdf->download('statement.pdf');
    }


    // Get transactions
    public function getTransactions($userId) {
        $data =  $this->transaction->whereUserId($userId)->paginate(20);
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $data
        ], 200);
    }

}

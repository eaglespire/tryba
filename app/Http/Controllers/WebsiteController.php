<?php

namespace App\Http\Controllers;

use App\Models\BookingConfiguration;
use App\Models\Settings;
use App\Models\Storeteam;
use App\Models\User;
use App\Models\Website;
use App\Models\WebsiteCustomization;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function createWebsite(){
    
        $user = User::find(Auth::user()->id);
        $xf = $user->getCountrySupported();
        if ($this->settings->store == 1) {
            if($xf->store == 1) {
                $website = Website::where('user_id',Auth::user()->id)->first();
                if(!empty($website)) {
                    return redirect(route('user.appointment'));
                }else{
                    $data['title'] = 'Create Website';
                    return view('user.website.user.create', $data);
                }
            } else {
                return response()->view('errors.custom',[
                    'title' => 'Error Message',
                    'error' => 'Website is not available for your country'
                ]);
            }
        } else {
            return response()->view('errors.custom',[
                'title' => 'Error Message',
                'error' => 'Website is currently unavailable'
            ]);
        }
    }


    public function submitWebsite(Request $request){
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $website = Website::create([
            'user_id' => Auth::user()->id,
            'websiteName' => $request->name,
            'meta_description' => $request->description,
            'websiteUrl' => $request->url
        ]);

         //DefaultConfigurations

         $defaultHours = [
            'monday' => ['startTime' => 9,'endTime' => 17,'status' => 1],
            'tuesday' => ['startTime' => 9,'endTime' => 17, 'status' => 1],
            'wednesday' => ['startTime' => 9,'endTime' => 17, 'status' => 1],
            'thursday' => ['startTime' => 9,'endTime' => 17, 'status' => 1 ],
            'friday' => ['startTime' => 9,'endTime' => 17, 'status' => 1 ],
            'saturday' => ['startTime' => 9,'endTime' => 17 ,'status' => 1],
            'sunday' => ['startTime' => 11,'endTime' => 17 ,'status' => 1],
        ];

        BookingConfiguration::create([
            'websiteID' => $website->id,
            'serviceType' => true,
            'whereServiceRendered' => true,
            'businessHours' => $defaultHours
        ]);
        
        //Default Menu 

        $defaultMenus = [
            ["text" => "Home","href" => route('website.link',['id' => $website->websiteUrl ]), "icon" => "","target" => "_top" ,"title" => "Home"],
            ["text" => "About","href" => route('website.about',['id' => $website->websiteUrl ]), "icon" => "","target" => "_top" ,"title" => "About"],
            ["text" => "Services","href" => route('website.services',['id' => $website->websiteUrl ]), "icon" => "","target" => "_top" ,"title" => "Services"],
            ["text" => "Blogs","href" => route('website.blogs',['id' => $website->websiteUrl ]), "icon" => "","target" => "_top" ,"title" => "Blogs"],
            ["text" => "Contact","href" => route('website.contact',['id' => $website->websiteUrl ]), "icon" => "","target" => "_top" ,"title" => "Contact"],
        ];


        WebsiteCustomization::create([
            'websiteID' => $website->id,
            'menus' => $defaultMenus,
            'slider' => NULL
        ]);

        return redirect(route('website.settings'));
      
    }

    public function checkWebsiteUrl(Request $request)
    {   
        if(Website::where('websiteUrl',$request->url)->count() == 0){
            return response()->json(['st' => 1]);
        }else{
            return response()->json(['st' => 2]);
        }
    }

    public function settings(){

        $website = Website::where('user_id',Auth::user()->id)->first();

        if(empty($website)){
            return redirect(route('new.website'));
        }

        return view('user.website.user.settings',[
            'title' => 'Website Settings',
            'website' => $website
        ]);

    }

    public function postWebsite(Request $request){

        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:50',
            'description' =>'required',
            'url' => 'required',
            'image' => 'mimes:jpg,png,jpeg|max:2000',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $fileUrl = "";
        if ($request->hasFile('image')) {
            $fileUrl = Cloudinary::uploadFile($request->file('image')->getRealPath())->getSecurePath();
        }


        Website::where('user_id',Auth::user()->id)->update([
            'websiteName' => $request->name,
            'meta_description' => $request->description,
            'logo_url' => $fileUrl,
            'status' => $request->status,
            'meta_keyword' => $request->meta_keywords
        ]);

        return redirect('user/website/settings')->with('toast_success', 'Website succesfully updated');
    }



    public function bookingApp(Request $request){

        $validator = Validator::make( $request->all(),[
            'serviceType' => 'boolean',
            'whereServiceRendered' =>'boolean',
            'county' => 'required_if:whereServiceRendered,1|integer|exists:counties,id',
            'city' => 'required_if:whereServiceRendered,1',
            'line' => 'required_if:whereServiceRendered,1',
            'city' => 'required_if:whereServiceRendered,1',
            'postcode' =>'required_if:whereServiceRendered,1',
            'dailyLimit' => 'required|integer',
            'review' =>'boolean',
            'statusHoilday' => 'nullable',
            'date' => 'required_if:statusHoilday,true'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $user = User::find(Auth::user()->id);

        $businessHours = $user->website->bookingConfiguration->businessHours;

        $updated = [];
        foreach ($businessHours as $key => $day) {
            $startTime = $key.'startTime';
            $endTime = $key.'endTime';
            if ($request->has($key.'status')) {
                $day['startTime'] = $request->$startTime;
                $day['endTime'] = $request->$endTime;
            } else {
                $day['status'] = 0;
            }

            $updated[$key] = [ 'startTime' => $day['startTime'], 'endTime' => $day['endTime'], 'status' => $day['status']];
        }

        $dates = [];
        if($request->has('statusHoilday')){
             $dates = explode("-",$request->date);
        }
      

        BookingConfiguration::where('websiteID',$user->website->id)->update([
            'serviceType' => $request->serviceType,
            'whereServiceRendered' => $request->whereServiceRendered,
            'businessHours' => $updated,
            'county' => ($request->county) ? $request->county :NULL,
            'city' => ($request->city) ? $request->city :NULL,
            'line' => ($request->line) ? $request->line :NULL,
            'postcode' => ($request->postcode) ? $request->postcode :NULL,
            'dailyLimit' => $request->dailyLimit,
            'startDateNoBookings' => (count($dates) > 1) ? Carbon::parse($dates[0])->format('Y-m-d') : NULL,
            'endDateNoBookings' => (count($dates) > 1) ? Carbon::parse($dates[1])->format('Y-m-d') : NULL,

        ]);
        return redirect('user/website/settings')->with('toast_success', 'Bookings Configuration succesfully updated');
    }

    public function widgets(){
        return view('user.website.user.widgets',[
            'title' => 'Website Widget'
        ]);
    }

    public function widgetsMenu(Request $request){

        $validator = Validator::make( $request->all(),[
            'menus' => 'string|required',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        WebsiteCustomization::where('websiteID',Auth::user()->website->id)->update([
            'menus' => $request->menus,
        ]);

        return back()->with('toast_success', 'Menus succesfully updated');

    }

    public function addSlider()
    {
        return view('user.website.user.slider.create', [
            'title' => 'Add Slide'
        ]);
    }

    public function createSlider(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'title1' => 'required|string',
            'title2' => 'required|string',
            'title3' => 'nullable|string',
            'button_text' =>'nullable|string',
            'button_link' => 'nullable|url',
            'file' => 'required|mimes:jpg,png,jpeg|max:2000'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        if ($request->hasFile('file')) {
            $fileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        }

        $customization = WebsiteCustomization::where('websiteID',Auth::user()->website->id)->firstorFail();

        $sliders =  (empty($customization->slider)) ? [] : $customization->slider;

        $slide = [
            'title1' => $request->title1,
            'title2' => $request->title2,
            'title3' => $request->title3,
            'button_text' => ($request->button_text) ? $request->button_text :NULL,
            'button_link' => ($request->button_link) ? $request->button_link :NULL,
            'url' => $fileUrl,
            'status' => 1
        ];
        array_push($sliders,$slide);

        WebsiteCustomization::where('websiteID',Auth::user()->website->id)->update([
            'slider' => $sliders
        ]);

        return redirect()->route('website.widgets')->with('toast_success', 'Slide added!');
    }

    public function editSlider($id)
    {
        $key = $id - 1;
        $customization = WebsiteCustomization::where('websiteID',Auth::user()->website->id)->firstorFail();
        
        $sliders = $customization->slider;

        if(array_key_exists($key,$sliders)){
            return view('user.website.user.slider.update',[
                'title' => 'Edit Slide',
                'slide' => $sliders[$key],
                'key' => $id
            ]);
        }else {
            abort(404);
        }
    }

    public function appointment()
    {
        return view('user.website.user.appoinments.dashboard', ['title' => 'Appointment']);
    }

    public function services(){
        return view('user.website.user.appoinments.services', ['title' => 'Services']);
    }

    public function pending(){
        return view('user.website.user.appoinments.pending', ['title' => 'Pending Appointment']);
    }

    public function completed(){
        return view('user.website.user.appoinments.completed', ['title' => 'Completed Appointment']);
    }


    public function updateSlider(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),[
            'title1' => 'required|string',
            'title2' => 'required|string',
            'title3' => 'nullable|string',
            'button_text' =>'nullable|string',
            'button_link' => 'nullable|url',
            'file' => 'nullable|mimes:jpg,png,jpeg|max:2000'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $key = $id - 1;
        $customization = WebsiteCustomization::where('websiteID',Auth::user()->website->id)->firstorFail();
        $sliders = $customization->slider;

        $fileUrl = "";
        if ($request->hasFile('file')) {
            $fileUrl = Cloudinary::uploadFile($request->file('file')->getRealPath())->getSecurePath();
        }

        $sliders[$key] = [
            'title1' => $request->title1,
            'title2' => $request->title2,
            'title3' => $request->title3,
            'button_text' => ($request->button_text) ? $request->button_text :NULL,
            'button_link' => ($request->button_link) ? $request->button_link :NULL,
            'url' => (!empty($fileUrl)) ? $fileUrl : $sliders[$key]['url'] ,
            'status' => 1
        ]; 

        WebsiteCustomization::where('websiteID',Auth::user()->website->id)->update([
            'slider' => $sliders
        ]);

        return redirect()->route('website.widgets')->with('toast_success', 'Slide Updated!');
    }

    public function deleteSlider($id){
        $customization = WebsiteCustomization::where('websiteID',Auth::user()->website->id)->firstorFail();
        $sliders = $customization->slider;
        $key = $id - 1;
        unset($sliders[$key]);

        WebsiteCustomization::where('websiteID',Auth::user()->website->id)->update([
            'slider' => $sliders
        ]);


        return redirect()->route('website.widgets')->with('toast_success', 'Slide Deleted!');
    }

    public function websiteThemes(){
        return view('user.website.user.theme', ['title' => 'Template']);
    }


    public function addTeam()
    {
        $data['title'] = 'Add Team';
        return view('user.website.user.team.create', $data);
    }

    public function createTeam(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'occupation'=>'required',
            'whatsapp' => 'nullable|active_url|url',
            'facebook' => 'nullable|active_url|url',
            'linkedin' => 'nullable|active_url|url',
            'twitter' => 'nullable|active_url|url',
            'instagram' => 'nullable|active_url|url',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2000'
        ]

        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $fileUrl = "";
        if ($request->hasFile('image')) {
            $fileUrl = Cloudinary::uploadFile($request->file('image')->getRealPath())->getSecurePath();
        }

        $data = new Storeteam();
        $data->title = $request->title;
        $data->occupation = $request->occupation;
        $data->whatsapp = $request->whatsapp;
        $data->facebook = $request->facebook;
        $data->linkedin = $request->linkedin;
        $data->instagram = $request->instagram;
        $data->twitter = $request->twitter;
        $data->websiteId = $id;
        $data->image = $fileUrl;
        $data->save();

        return redirect()->route('website.widgets')->with('toast_success', 'Team member added!');
    }

    public function editTeam($id)
    {
        $data['title'] = 'Edit Team';
        $data['val'] = Storeteam::findOrFail($id);
        return view('user.website.user.team.edit', $data);
    }

    public function DeleteTeam($id)
    {
        $data = Storeteam::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Team member deleted!');
    }
    public function updateTeam(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'occupation'=>'required',
            'whatsapp' => 'nullable|active_url|url',
            'facebook' => 'nullable|active_url|url',
            'linkedin' => 'nullable|active_url|url',
            'twitter' => 'nullable|active_url|url',
            'instagram' => 'nullable|active_url|url',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'status' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $fileUrl = "";
        if ($request->hasFile('image')) {
            $fileUrl = Cloudinary::uploadFile($request->file('image')->getRealPath())->getSecurePath();
        }
        $data = Storeteam::findOrFail($id);
        $data->title = $request->title;
        $data->occupation = $request->occupation;
        $data->whatsapp = $request->whatsapp;
        $data->facebook = $request->facebook;
        $data->linkedin = $request->linkedin;
        $data->instagram = $request->instagram;
        $data->twitter = $request->twitter;
        $data->image = (!empty($fileUrl)) ? $fileUrl : $data->image;
        $data->status = $request->status;
        $data->save();

        return redirect()->route('website.widgets')->with('toast_success', 'Team member updated!');
    }


    public function defaultTheme($themeId){

        $website = Website::where('user_id',Auth::user()->id)->firstorFail();
        $website->theme_id = $themeId;
        $website->save();

        return back()->with('toast_success', 'Theme activated!');

    }
}


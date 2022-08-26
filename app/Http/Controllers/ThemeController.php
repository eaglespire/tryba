<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\ThemeSliders;
use App\Models\ThemeFeature;
use App\Models\Storefront;
use App\Models\Storepages;
use App\Models\Storeblog;
use App\Models\Storeblogcat;
use App\Models\Storefaq;
use App\Models\Storefaqcat;
use App\Models\Menu;
use App\Models\Storereview;
use App\Models\Storebrand;
use App\Models\Storeteam;
use App\Jobs\importDemo;
use App\Models\HomepageSettings;
use App\Models\WebsiteThemes;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Validator;
use Image;
use Str;

class ThemeController extends Controller
{
    public function edit()
    {
        $data['title'] = 'Edit Theme';
        return view('user.product.theme', $data);
    }
    //Slider
    public function addSlider()
    {
        $data['title'] = 'Add Slide';
        return view('user.product.sliders.create', $data);
    }
    public function editSlider($id)
    {
        $data['title'] = 'Edit Slide';
        $data['val'] = ThemeSliders::findOrFail($id);
        return view('user.product.sliders.edit', $data);
    }
    public function DeleteSlider($id)
    {
        $data = ThemeSliders::findOrFail($id);
        File::delete(public_path('asset/profile/' . $data->image));
        $data->delete();
        return back()->with('toast_success', 'Slide deleted!');
    }
    public function createSlider(Request $request, $id)
    {
        $data = new ThemeSliders();
        $data->title1 = $request->title1;
        $data->title2 = $request->title2;
        $data->title3 = $request->title3;
        $data->slug = Str::random(16);
        $data->store_id = $id;
        //$data->background_image = $request->background_image;
        if (!empty($request->button_status)) {
            $data->button_text = $request->button_text;
            $data->button_link = $request->button_link;
        }
        $data->button_status = $request->button_status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'slide-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('theme.slider.store')->with('toast_success', 'Slide added!');
    }
    public function updateSlider(Request $request, $id)
    {
        $data = ThemeSliders::findOrFail($id);
        $data->title1 = $request->title1;
        $data->title2 = $request->title2;
        $data->title3 = $request->title3;
        $data->status = $request->status;
        //$data->background_image = $request->background_image;
        if (!empty($request->button_status)) {
            $data->button_text = $request->button_text;
            $data->button_link = $request->button_link;
        }
        $data->button_status = $request->button_status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'slide-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($data->image != null) {
                File::delete('./asset/profile/' . $data->image);
            }
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('theme.slider.store')->with('toast_success', 'Slide updated!');
    }
    //Feature
    public function addFeature()
    {
        $data['title'] = 'Add Feature';
        return view('user.product.feature.create', $data);
    }
    public function editFeature($id)
    {
        $data['title'] = 'Edit Feature';
        $data['val'] = ThemeFeature::findOrFail($id);
        return view('user.product.feature.edit', $data);
    }
    public function DeleteFeature($id)
    {
        $data = ThemeFeature::findOrFail($id);
        File::delete(public_path('asset/profile/' . $data->image));
        $data->delete();
        return back()->with('toast_success', 'Feature deleted!');
    }
    public function createFeature(Request $request, $id)
    {
        $data = new ThemeFeature();
        $data->title1 = $request->title1;
        $data->title2 = $request->title2;
        $data->title3 = $request->title3;
        $data->slug = Str::random(16);
        $data->store_id = $id;
        //$data->background_image = $request->background_image;
        if (!empty($request->button_status)) {
            $data->button_text = $request->button_text;
            $data->button_link = $request->button_link;
        }
        $data->button_status = $request->button_status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'feature-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('theme.features.store')->with('toast_success', 'Feature added!');
    }
    public function updateFeature(Request $request, $id)
    {
        $data = ThemeFeature::findOrFail($id);
        $data->title1 = $request->title1;
        $data->title2 = $request->title2;
        $data->title3 = $request->title3;
        $data->status = $request->status;
        //$data->background_image = $request->background_image;
        if (!empty($request->button_status)) {
            $data->button_text = $request->button_text;
            $data->button_link = $request->button_link;
        }
        $data->button_status = $request->button_status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'feature-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            if ($data->image != null) {
                File::delete(public_path('asset/profile/' . $data->image));
            }
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('theme.features.store')->with('toast_success', 'Feature updated!');
    }

    //Review
    public function addReview()
    {
        $data['title'] = 'Add Review';
        return view('user.product.review.create', $data);
    }
    public function editReview($id)
    {
        $data['title'] = 'Edit Review';
        $data['val'] = Storereview::findOrFail($id);
        return view('user.product.review.edit', $data);
    }
    public function DeleteReview($id)
    {
        $data = Storereview::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Review deleted!');
    }
    public function createReview(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'review'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = new Storereview();
        $data->title = $request->title;
        $data->review = $request->review;
        $data->occupation = $request->occupation;
        $data->store_id = $id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'review-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.review')->with('toast_success', 'Review added!');
    }
    public function updateReview(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'review'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = Storereview::findOrFail($id);
        $data->title = $request->title;
        $data->review = $request->review;
        $data->occupation = $request->occupation;
        $data->status = $request->status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'review-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.review')->with('toast_success', 'Review updated!');
    }
    //Brand
    public function addBrand()
    {
        $data['title'] = 'Add Brand';
        return view('user.product.brand.create', $data);
    }
    public function editBrand($id)
    {
        $data['title'] = 'Edit Brand';
        $data['val'] = Storebrand::findOrFail($id);
        return view('user.product.brand.edit', $data);
    }
    public function DeleteBrand($id)
    {
        $data = Storebrand::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Brand deleted!');
    }
    public function createBrand(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'image'=>'required',
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = new Storebrand();
        $data->title = $request->title;
        $data->store_id = $id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'brand-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.brand')->with('toast_success', 'Brand added!');
    }
    public function updateBrand(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'image'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = Storebrand::findOrFail($id);
        $data->title = $request->title;
        $data->status = $request->status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'brand-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.brand')->with('toast_success', 'Brand updated!');
    }
    //Page
    public function addPage()
    {
        $data['title'] = 'Add Page';
        return view('user.product.page.create', $data);
    }
    public function editPage($id)
    {
        $data['title'] = 'Edit Page';
        $data['val'] = Storepages::findOrFail($id);
        return view('user.product.page.edit', $data);
    }
    public function DeletePage($id)
    {
        $data = Storepages::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Page deleted!');
    }
    public function createPage(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'body'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = new Storepages();
        $data->title = $request->title;
        $data->body = $request->body;
        $data->slug = str_slug($request->title);
        $data->store_id = $id;
        $data->save();
        return redirect()->route('website.page')->with('toast_success', 'Page added!');
    }
    public function updatePage(Request $request, $id)
    {
        $validator = Validator::make( $request->all(),
        [
            'title'=>'required',
            'body'=>'required'
        ]
        );
        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }
        $data = Storepages::findOrFail($id);
        $data->title = $request->title;
        $data->body = $request->body;
        $data->slug = str_slug($request->title);
        $data->status = $request->status;
        $data->save();
        return redirect()->route('website.page')->with('toast_success', 'Page updated!');
    }
    //Blog
    public function addBlog()
    {
        $data['title'] = 'Add Article';
        return view('user.product.blog.create', $data);
    }
    public function editBlog($id)
    {
        $data['title'] = 'Edit Article';
        $data['val'] = Storeblog::findOrFail($id);
        return view('user.product.blog.edit', $data);
    }
    public function DeleteBlog($id)
    {
        $data = Storeblog::findOrFail($id);
        File::delete(public_path('asset/profile/' . $data->image));
        $data->delete();
        return back()->with('toast_success', 'Article deleted!');
    }
    public function createBlog(Request $request, $id)
    {
        $data = new Storeblog();
        $data->title = $request->title;
        $data->body = $request->body;
        $data->slug = str_slug($request->title);
        $data->store_id = $id;
        $data->cat_id = $request->cat_id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'blog-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.blog')->with('toast_success', 'Article added!');
    }
    public function updateBlog(Request $request, $id)
    {
        $data = Storeblog::findOrFail($id);
        $data->title = $request->title;
        $data->body = $request->body;
        $data->slug = str_slug($request->title);
        $data->status = $request->status;
        $data->cat_id = $request->cat_id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'blog-' . time() . '.' . $image->extension();
            $location = public_path('asset/profile/' . $filename);
            Image::make($image)->save($location);
            $data->image = $filename;
        }
        $data->save();
        return redirect()->route('website.blog')->with('toast_success', 'Article updated!');
    }
    public function addBlogCat()
    {
        $data['title'] = 'Add Category';
        return view('user.product.blog.cat.create', $data);
    }
    public function editBlogCat($id)
    {
        $data['title'] = 'Edit Catogory';
        $data['val'] = Storeblogcat::findOrFail($id);
        return view('user.product.blog.cat.edit', $data);
    }
    public function DeleteBlogCat($id)
    {
        if(Storeblog::wherecat_id($id)->wherestore_id(auth()->guard('user')->user()->storefront()->id)->count()>0){
            return back()->with('toast_warning', 'An article uses this category, please delete this article first or change the category!');
        }else{
            $data = Storeblogcat::findOrFail($id);
            $data->delete();
            return back()->with('toast_success', 'Category deleted!');
        }
    }
    public function createBlogCat(Request $request, $id)
    {
        if(Storeblogcat::wheretitle($request->title)->wherestore_id(auth()->guard('user')->user()->storefront()->id)->count()>0){
            return back()->with('toast_warning', 'Category already added!');
        }else{
            $data = new Storeblogcat();
            $data->store_id = $id;
            $data->title = $request->title;
            $data->save();
            return redirect()->route('customer.blog.cat')->with('toast_success', 'Category added!');
        }
    }
    public function updateBlogCat(Request $request, $id)
    {
        $data = Storeblogcat::findOrFail($id);
        if(Storeblogcat::wheretitle($request->title)->wherestore_id($data->store_id)->where('id', '!=', $id)->count()>0){
            return back()->with('toast_warning', 'Category already added!');
        }else{
            $data->title = $request->title;
            $data->save();
            return redirect()->route('customer.blog.cat')->with('toast_success', 'Category updated!');
        }
    }
    //Faq
    public function addFaq()
    {
        $data['title'] = 'Add Question';
        return view('user.product.faq.create', $data);
    }
    public function editFaq($id)
    {
        $data['title'] = 'Edit Question';
        $data['val'] = Storefaq::findOrFail($id);
        return view('user.product.faq.edit', $data);
    }
    public function DeleteFaq($id)
    {
        $data = Storefaq::findOrFail($id);
        $data->delete();
        return back()->with('toast_success', 'Faq deleted!');
    }
    public function createFaq(Request $request, $id)
    {
        $data = new Storefaq();
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->store_id = $id;
        $data->cat_id = $request->cat_id;
        $data->save();
        return redirect()->route('website.faq')->with('toast_success', 'Faq added!');
    }
    public function updateFaq(Request $request, $id)
    {
        $data = Storefaq::findOrFail($id);
        $data->question = $request->question;
        $data->answer = $request->answer;
        $data->cat_id = $request->cat_id;
        $data->save();
        return redirect()->route('website.faq')->with('toast_success', 'Faq updated!');
    }
    public function addFaqCat()
    {
        $data['title'] = 'Add Category';
        return view('user.product.faq.cat.create', $data);
    }
    public function editFaqCat($id)
    {
        $data['title'] = 'Edit Catogory';
        $data['val'] = Storefaqcat::findOrFail($id);
        return view('user.product.faq.cat.edit', $data);
    }
    public function DeleteFaqCat($id)
    {
        if(Storefaq::wherecat_id($id)->wherestore_id(auth()->guard('user')->user()->storefront()->id)->count()>0){
            return back()->with('toast_warning', 'An article uses this category, please delete this faq first or change the category!');
        }else{
            $data = Storefaqcat::findOrFail($id);
            $data->delete();
            return back()->with('toast_success', 'Category deleted!');
        }
    }
    public function createFaqCat(Request $request, $id)
    {
        if(Storefaqcat::wheretitle($request->title)->wherestore_id(auth()->guard('user')->user()->storefront()->id)->count()>0){
            return back()->with('toast_warning', 'Category already added!');
        }else{
            $data = new Storefaqcat();
            $data->store_id = $id;
            $data->title = $request->title;
            $data->save();
            return redirect()->route('customer.faq.cat')->with('toast_success', 'Category added!');
        }
    }
    public function updateFaqCat(Request $request, $id)
    {
        $data = Storefaqcat::findOrFail($id);
        if(Storefaqcat::wheretitle($request->title)->wherestore_id($data->store_id)->where('id', '!=', $id)->count()>0){
            return back()->with('toast_warning', 'Category already added!');
        }else{
            $data->title = $request->title;
            $data->save();
            return redirect()->route('customer.faq.cat')->with('toast_success', 'Category updated!');
        }
    }
    //Text
    public function updateText(Request $request, $id)
    {
        $data = HomepageSettings::wherestore_id($id)->first();
        if(!$data) {
            return back()->with('toast_error', 'No Homepage settings added.');
        }

        $data->fill($request->all())->save();
        if(!empty($request->slider_status)){
            $data->slider_status=1;
        }else{
            $data->slider_status=0;
        }
        if(!empty($request->blog_status)){
            $data->blog_status=1;
        }else{
            $data->blog_status=0;
        }
        if(!empty($request->review_status)){
            $data->review_status=1;
        }else{
            $data->review_status=0;
        }
        if(!empty($request->services_status)){
            $data->services_status=1;
        }else{
            $data->services_status=0;
        }
        if(!empty($request->team_status)){
            $data->team_status=1;
        }else{
            $data->team_status=0;
        }
        if(!empty($request->statistics_status)){
            $data->statistics_status=1;
        }else{
            $data->statistics_status=0;
        }
        $data->save();
        return redirect()->route('theme.edit.store')->with('toast_success', 'Homepage updated!');
    }

    public function menuUpdate(Request $request, $id) {
        Menu::wherestore_id($id)->delete();
        $menu = new Menu();
        $menu->store_id = $id;
        $menu->menus = json_decode($request->str, true);
        $menu->save();
        return response()->json(['status' => 'success', 'message' => 'Menu updated successfully!']);
    }

    public function importDemo($id)
    {
        $data = Storefront::findOrFail($id);
        if ($data->theme_id == 1) {
            $data->color = "#ffd877";
            $data->text_color = "#001e57";
            $data->welcome_status = 1;
            $data->welcome_title = "Find products for your Shop Store";
            $data->welcome_message = "Tryba enables you to easily set up your storefront";
            $data->save();
        } elseif ($data->theme_id == 2) {
            $welcome_filename = 'welcome' . time() . '.jpg';
            $data->welcome_title = "100%";
            $data->welcome_title2 = "Origin Coffee";
            $data->welcome_message = "Welcome to Coffee Stores";
            File::copy(public_path('asset/themes/2/sliders/coffee-01.jpg'), public_path('asset/profile/'.$welcome_filename));
            $data->welcome_image = $welcome_filename;
            $data->save();
            foreach (getThemeSliders($id) as $val) {
                $val->status = 0;
                $val->save();
            }
            $slide = new ThemeSliders();
            $slide1_filename = 'slide' . time() . '.jpg';
            $slide->title1 = 'Text 1';
            $slide->title2 = 'Text 2';
            $slide->title3 = 'Text 3';
            $slide->slug = Str::random(16);
            $slide->store_id = $id;
            File::copy(public_path('asset/themes/2/sliders/coffee-02.jpg'), public_path('asset/profile/' . $slide1_filename));
            $slide->image = $slide1_filename;
            $slide->save();

            $slide = new ThemeSliders();
            $slide2_filename = 'slide' . time() . '.jpg';
            $slide->title1 = 'Text 1';
            $slide->title2 = 'Text 2';
            $slide->title3 = 'Text 3';
            $slide->slug = Str::random(16);
            $slide->store_id = $id;
            File::copy(public_path('asset/themes/2/sliders/coffee-03.jpg'), public_path('asset/profile/' . $slide2_filename));
            $slide->image = $slide2_filename;
            $slide->save();
        } elseif ($data->theme_id == 3) {
            $welcome_filename = 'welcome' . time() . '.jpg';
            $data->welcome_title = "Centre for Healthy nutrition";
            $data->welcome_title2 = "Call us: +1-234-567-89-01";
            $data->welcome_title3 = 'We are Glad to Surprise You';
            $data->welcome_title4 = 'Do not wait for tomorrow - start a new life today!';
            $data->welcome_message = "Daily from 9:00 to 19:00";
            File::copy(public_path('asset/themes/3/sliders/mainpromo-img-01.jpg'), public_path('asset/profile/' . $welcome_filename));
            $data->welcome_image = $welcome_filename;
            $data->save();
            foreach (getThemeFeature($id) as $val) {
                $val->status = 0;
                $val->save();
            }

            $feature = new ThemeFeature();
            $feature1_filename = 'feature' . time() . '.jpg';
            $feature->title1 = 'Weight Loss';
            $feature->title2 = 'A delicious and easy way to join a healthy diet and control your weight and well-being.';
            $feature->slug = Str::random(16);
            $feature->store_id = $id;
            File::copy(public_path('asset/themes/3/sliders/promo-img-01.jpg'), public_path('asset/profile/' . $feature1_filename));
            $feature->image = $feature1_filename;
            $feature->save();

            $feature = new ThemeFeature();
            $feature2_filename = 'feature' . time() . '.jpg';
            $feature->title1 = 'Balanced Diet';
            $feature->title2 = 'Tasty and easy way to join a healthy diet, control your weight and health.';
            $feature->slug = Str::random(16);
            $feature->store_id = $id;
            File::copy(public_path('asset/themes/3/sliders/promo-img-02.jpg'), public_path('asset/profile/' . $feature2_filename));
            $feature->image = $feature2_filename;
            $feature->save();

            $feature = new ThemeFeature();
            $feature3_filename = 'feature' . time() . '.jpg';
            $feature->title1 = 'Sports Nutrition';
            $feature->title2 = 'Active growth of muscle mass, relief formation, drying - choose your own mode.';
            $feature->slug = Str::random(16);
            $feature->store_id = $id;
            File::copy(public_path('asset/themes/3/sliders/promo-img-03.jpg'), public_path('asset/profile/' . $feature3_filename));
            $feature->image = $feature3_filename;
            $feature->save();
        } elseif ($data->theme_id == 5) {
            $welcome_filename = 'welcome' . time() . '.jpg';
            $data->welcome_title = "WELCOME!";
            $data->welcome_title2 = "ABOUT OUR STORE";
            $data->welcome_message = "Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.";
            $data->save();
            foreach (getThemeSliders($id) as $val) {
                $val->status = 0;
                $val->save();
            }
            $slide = new ThemeSliders();
            $slide1_filename = 'slide' . time() . '.jpg';
            $slide->title1 = 'Text 1';
            $slide->title2 = 'Text 2';
            $slide->title3 = 'Text 3';
            $slide->slug = Str::random(16);
            $slide->store_id = $id;
            File::copy(public_path('asset/themes/5/sliders/slide-02.jpg'), public_path('asset/profile/' . $slide1_filename));
            $slide->image = $slide1_filename;
            $slide->save();

            $slide = new ThemeSliders();
            $slide2_filename = 'slide' . time() . '.jpg';
            $slide->title1 = 'Text 1';
            $slide->title2 = 'Text 2';
            $slide->title3 = 'Text 3';
            $slide->slug = Str::random(16);
            $slide->store_id = $id;
            File::copy(public_path('asset/themes/5/sliders/slide-03.jpg'), public_path('asset/profile/' . $slide2_filename));
            $slide->image = $slide2_filename;
            $slide->save();
        } elseif ($data->theme_id == 6) {
            $welcome_filename = 'welcome' . time() . '.jpg';
            $data->welcome_title = "Limited-time only";
            $data->welcome_title2 = "Get up to 50% Off";
            File::copy(public_path('asset/themes/6/sliders/slide-01.jpg'), public_path('asset/profile/' . $welcome_filename));
            $data->welcome_image = $welcome_filename;
            $data->save();
        }
        return back()->with('toast_success', 'Demo is importing!');
    }

    public function getAllTheme(){
        $themes = WebsiteThemes::all();
        return view('admin.themes.website.index',[
            'title' => "Website Themes",
            'themes' =>$themes
        ]);
    }


    public function showCreate(){
        return view('admin.themes.website.create',[
            'title' => "Add Themes",
        ]);
    }

    public function addTheme(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'premuim' =>'nullable|boolean',
            'previewImage' =>'mimes:jpg,png,jpeg|max:2000',
            'category' =>'required|string',
            'theme' => 'nullable|mimes:zip|max:20000'

        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        
        $fileUrl = "";
        if ($request->hasFile('previewImage')) {
            $fileUrl = Cloudinary::uploadFile($request->file('previewImage')->getRealPath())->getSecurePath();
        }

        WebsiteThemes::create([
            'themeName' => $request->name,
            'category' => $request->category,
            'isPremuim' => ($request->has('premuim')) ?  $request->premuim : false,
            'previewImage' => $fileUrl
        ]);

        return redirect()->route('admin.website.themes')->with('toast_success', 'Theme Added!');
    }

    public function updateTheme(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'premuim' =>'nullable|boolean',
            'previewImage' =>'nullable|mimes:jpg,png,jpeg|max:2000',
            'category' =>'required|string',
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $fileUrl = "";
        if ($request->hasFile('previewImage')) {
            $fileUrl = Cloudinary::uploadFile($request->file('previewImage')->getRealPath())->getSecurePath();
        }

        $theme = WebsiteThemes::where('id',$id)->first();

        WebsiteThemes::where('id',$id)->update([
            'themeName' => $request->name,
            'category' => $request->category,
            'isPremuim' => ($request->has('premuim')) ?  $request->premuim : false,
            'previewImage' => (!empty($fileUrl)) ? $fileUrl : $theme->previewImage
        ]);

        return redirect()->route('admin.website.themes')->with('toast_success', 'Theme Updated!');
    }
}

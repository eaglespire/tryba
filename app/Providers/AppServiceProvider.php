<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Validator;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Settings;
use App\Models\Blog;
use App\Models\Logo;
use App\Models\Currency;
use App\Models\Social;
use App\Models\Faq;
use App\Models\Category;
use App\Models\Page;
use App\Models\Design;
use App\Models\About;
use App\Models\Review;
use App\Models\User;
use App\Models\Services;
use App\Models\Brands;
use App\Models\Ticket;
use App\Models\Adminbank;
use App\Models\Contact;
use App\Models\Countrysupported;
use App\Models\Shipcountry;
use App\Models\Transactions;
use App\Models\Wishlist;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        View::composer('*', function($view){
            $set=getSetting();
            $cdd=Shipcountry::where('phonecode', '!=', 0)->orderby('name', 'asc')->get();
            if (Auth::guard('admin')->check()) {
                $admin=Admin::find(Auth::guard('admin')->user()->id);
                $unread=Contact::whereseen(0)->count();
                $view->with('admin', $admin);
                $view->with('unread', $unread);
            }
            if (Auth::guard('customer')->check()) {
                $wishlistcount=Wishlist::wherecustomer_id(Auth::guard('customer')->user()->id)->wherestore_id(Auth::guard('customer')->user()->store_id)->count();
                $view->with('wishlistcount', $wishlistcount);
            }
            if (Auth::guard('user')->check()) {
                $user=User::find(Auth::guard('user')->user()->id);
                $xf=Countrysupported::whereid($user->pay_support)->first();
                $currency=Currency::whereid($xf->coin_id)->first();
                if($user->image==null){
                    $cast="person.png";
                }else{
                    $cast=$user->image;
                }
                $profit=Transactions::wherereceiver_id(Auth::guard('user')->user()->id)->wheremode($user->live)->wherestatus(1)->where('type', '!=', 9)->get();
                $view->with('profit', $profit);
                $view->with('user', $user);
                $view->with('cast', $cast);
                $view->with('currency', $currency);
                $view->with('xf', $xf);
            }
            $pticket=Ticket::where('status', 0)->get();
            $view->with('pticket', $pticket);
            $view->with('set', $set);
            $view->with('pc_percent', $set->pc_percent);
            $view->with('pc_fiat', $set->pc_fiat);
            $view->with('cdd', $cdd);
        });
        $data['set']=Settings::first();
        $data['blog']=Blog::whereStatus(1)->get();
        $data['logo']=Logo::first();
        $data['social']=Social::all();
        $data['faq']=Faq::all();
        $data['cat']=Category::all();
        $data['pages']=Page::whereStatus(1)->get();
        $data['ui']=Design::first();
        $data['about']=About::first();
        $data['trending'] = Blog::whereStatus(1)->orderBy('views', 'DESC')->limit(5)->get();
        $data['posts'] = Blog::whereStatus(1)->orderBy('views', 'DESC')->limit(5)->get();
        $data['review'] = Review::whereStatus(1)->get();
        $data['item'] = Services::orderby('id', 'asc')->get();
        $data['item4'] = Services::whereId(4)->first();
        $data['brand'] = Brands::whereStatus(1)->get();
        $data['xfaq']=Faq::first();


        view::share($data);
    }
}

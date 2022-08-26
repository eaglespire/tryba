<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Product;
use App\Models\Countrysupported;
use App\Models\Cart;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Fundcategory;
use Illuminate\Support\Facades\Session;

class MarketController extends Controller
{
    //Store 
    public function __construct()
    {
        $this->settings=Settings::find(1);
    }
    public function searchmarket(Request $request)
    {
        $data['products'] = Product::wherestatus(1)->where('description', 'LIKE', '%' . $request->search . '%')->orWhere('name', 'LIKE', '%' . $request->search . '%')->orWhere('tags', 'LIKE', '%' . $request->search . '%')->orderby('id', 'desc')->paginate(16);
        $data['title'] = $request->search;
        $data['cat'] = $request->search;
        $data['country'] = getSupportedCountries();
        $data['category'] = getProductCategory();
        return view('user.product.market.search', $data);
    }
    public function marketcountry($id)
    {
        $data['countryx'] = getSupportedCountries();
        $data['country_spp'] = $country_spp = Countrysupported::whereid($id)->first();
        $data['country'] = $country = Country::whereid($country_spp->country_id)->first();
        $fc = Currency::whereid($country_spp->coin_id)->first();
        $data['products'] = Product::wherecurrency($fc->id)->wherestatus(1)->orderby('id', 'desc')->paginate(16);
        $data['title'] = $country->nicename;
        $data['cat'] = $country->nicename;
        $data['category'] = getProductCategory();
        return view('user.product.market.country', $data);
    }
    public function marketcat($cat)
    {
        $data['country'] = getSupportedCountries();
        $data['products'] = Product::wherecat_id($cat)->wherestatus(1)->orderby('id', 'desc')->paginate(16);
        $rr = Fundcategory::whereid($cat)->first();
        $data['title'] = $rr->name;
        $data['cat'] = $rr->name;
        $data['category'] = getProductCategory();
        return view('user.product.market.category', $data);
    }
    public function market()
    {
        $data['cart'] = Cart::where('uniqueid', Session::get('uniqueid'))->get();
        $data['gtotal'] = Cart::where('uniqueid', Session::get('uniqueid'))->sum('total');
        $data['country'] = getSupportedCountries();
        $data['title'] = 'Find your favourite business online';
        $data['category'] = getProductCategory();
        return view('user.product.market.index', $data);
    }
}

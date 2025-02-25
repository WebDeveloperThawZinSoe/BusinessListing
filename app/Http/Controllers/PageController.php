<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Shop;
use App\Models\SocialAccount;
use App\Models\Product;
use App\Models\ShopGallery;
use App\Models\FAQ;

class PageController extends Controller
{
    //index
    public function index(){
        $categories = Category::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.index",compact("categories"));
    }

    //categoryDetail
    public function categoryDetail($slug){
        $category = Category::where("slug",$slug)->where("is_active",1)->firstOrFail();
        $shops = Shop::where("category_id",$category->id)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        return view("web.category",compact("category","shops"));
    }

    //regions
    public function regions(){
        $cities = City::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.region",compact("cities"));
    }

    //regionDetail
    public function regionDetail($slug){
        $city = City::where("slug",$slug)->where("is_active",1)->firstOrFail();
        $shops = Shop::where("city_id",$city->id)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        return view("web.cityDetail",compact("city","shops"));
    }

    //products
    public function products(){

    }

    //faq
    public function faq(){
       $faqs = FAQ::where("is_active",1)->get();
       return view("web.faq",compact("faqs"));
    }

    //contact
    public function contact(){

    }

    //shops
    public function shops(){
        $feature_shops =  Shop::where("is_featured",1)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        $other_shops =  Shop::where("is_featured",0)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        return view("web.shops",compact("feature_shops","other_shops"));
    }

    //shop detail
    public function shopDetail($slug){
        $shop = Shop::where("slug",$slug)->where("is_active",1)->where("is_suspended",0)->firstOrFail();
        $socials  = SocialAccount::where("shop_id",$shop->id)->where("is_active",1)->get();
        $shopGallerys = ShopGallery::where("shop_id",$shop->id)->inRandomOrder()->take(9)->get();
        $products = Product::where("shop_id",$shop->id)->where('is_active',1)->where("is_suspended",0)->paginate(15);
        return view("web.shopDetail",compact("shop","socials","shopGallerys","products"));
    }


}

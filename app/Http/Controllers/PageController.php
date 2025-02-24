<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Shop;

class PageController extends Controller
{
    //index
    public function index(){
        $categories = Category::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.index",compact("categories"));
    }

    //categoryDetail
    public function categoryDetail($slag){
        $category = Category::where("slug",$slag)->where("is_active",1)->firstOrFail();
        $shops = Shop::where("category_id",$category->id)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        return view("web.category",compact("category","shops"));
    }

    //regions
    public function regions(){
        $cities = City::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.region",compact("cities"));
    }

    //products
    public function products(){

    }

    //faq
    public function faq(){

    }

    //contact
    public function contact(){

    }

    //shops
    public function shops(){

    }

    //shop detail
    public function shopDetail($slag){
        $shop = Shop::where("slug",$slag)->where("is_active",1)->where("is_suspended",0)->firstOrFail();
        return view("web.shopDetail",compact("shop"));
    }

    //product detail
    public function productDetail($slag){

    }
}

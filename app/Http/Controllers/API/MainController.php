<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Shop;
use App\Models\SocialAccount;
use App\Models\Product;
use App\Models\ShopGallery;
use App\Models\FAQ;
use App\Models\Traffic;
use Carbon\Carbon;


class MainController extends Controller
{
    //category
    public function category(){
        $categories = Category::where("is_active",1)->orderBy("order","desc")->get();
        return response()->json([
            'status' => true,
            'message' => 'Category list retrieved successfully',
            'data' => $categories
        ], 200);
    }   

    //region
    public function region(){
        $cities = City::where("is_active",1)->orderBy("order","desc")->get();
        return response()->json([
            'status' => true,
            'message' => 'Regions list retrieved successfully',
            'data' => $cities
        ], 200);
    }
}

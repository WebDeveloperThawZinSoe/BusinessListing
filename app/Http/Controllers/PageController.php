<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Contact;
use App\Models\Category;
use App\Models\City;
use App\Models\Shop;
use App\Models\SocialAccount;
use App\Models\Product;
use App\Models\ShopGallery;
use App\Models\FAQ;
use App\Models\Traffic;
use Carbon\Carbon;

class PageController extends Controller
{
    //index
    public function index(){
        $this->UpdateViewCount();
        $categories = Category::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.index",compact("categories"));
    }

    //categoryDetail
    public function categoryDetail($slug){
        $this->UpdateViewCount();
        $category = Category::where("slug",$slug)->where("is_active",1)->firstOrFail();
        $shops = Shop::where("category_id",$category->id)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->paginate(15);
        return view("web.category",compact("category","shops"));
    }

    //regions
    public function regions(){
        $this->UpdateViewCount();
        $cities = City::where("is_active",1)->orderBy("order","desc")->get();
        return view("web.region",compact("cities"));
    }

    //regionDetail
    public function regionDetail($slug){
        $this->UpdateViewCount();
        $city = City::where("slug",$slug)->where("is_active",1)->firstOrFail();
        $shops = Shop::where("city_id",$city->id)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->paginate(15);
        return view("web.cityDetail",compact("city","shops"));
    }



    //faq
    public function faq(){
        $this->UpdateViewCount();
       $faqs = FAQ::where("is_active",1)->get();
       return view("web.faq",compact("faqs"));
    }

    //contact
    public function contact(){
        $this->UpdateViewCount();
        return view("web.contact");
    }

    //submit
    public function submit(Request $request)
    {
        // Validate form data + reCAPTCHA
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'message' => 'required|string|max:1000',
            'g-recaptcha-response' => 'required'
        ]);

        // Verify reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $response->json();

        if (!$recaptchaData['success']) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }

        // Store contact message
        Contact::create($request->only(['name', 'email', 'phone', 'message']));

        return back()->with('success', 'Your message has been sent successfully!');
    }

    //shops
    public function shops(){
        $this->UpdateViewCount();
        $feature_shops =  Shop::where("is_featured",1)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->get();
        $other_shops =  Shop::where("is_featured",0)->where("is_active",1)->where("is_suspended",0)->orderBy("id","desc")->paginate(15);
        return view("web.shops",compact("feature_shops","other_shops"));
    }

    //shop detail
    public function shopDetail($slug){
        $this->UpdateViewCount();
        $shop = Shop::where("slug",$slug)->where("is_active",1)->where("is_suspended",0)->firstOrFail();
        $socials  = SocialAccount::where("shop_id",$shop->id)->where("is_active",1)->get();
        $shopGallerys = ShopGallery::where("shop_id",$shop->id)->inRandomOrder()->take(9)->get();
        $products = Product::where("shop_id",$shop->id)->where('is_active',1)->where("is_suspended",0)->paginate(15);
        return view("web.shopDetail",compact("shop","socials","shopGallerys","products"));
    }


    public function UpdateViewCount()
    {
        $today = Carbon::today(); // Get current date
    
        $viewCount = Traffic::where('date', $today)->where("type","web")->first();
    
        if ($viewCount) {
            // If today's record exists, increase count
            $viewCount->increment('count');
        } else {
            // If no record exists for today, create one
            Traffic::create([
                'date' => $today,
                "type" => "web",
                'count' => 1
            ]);
        }
    }

}

@extends('web.master')

@section('body')

<!-- Add this CSS to ensure uniform image heights -->
<style>
.fixed-height {
    height: 250px;
    /* Set a fixed height */
    object-fit: cover;
    /* Ensures image fills the space without stretching */
    width: 100%;
    /* Ensures the width is responsive */
    border-radius: 8px;
    /* Optional: Adds rounded corners */
}
</style>

<!-- CSS for Fixed Image Size -->
<style>
.product-img {
    height: 200px;
    /* Set a fixed height */
    object-fit: cover;
    /* Prevents distortion */
    width: 100%;
    border-radius: 8px;
}
</style>


<div class="container mt-5">
    <!-- Shop Profile Header Section (Facebook-like) -->
    @if($shop->cover_photo)
    <div class="row">
        <!-- Cover Photo Section -->
        <div class="col-12">
            <img src="{{ asset('storage/' . $shop->cover_photo) }}" class="img-fluid w-100" alt="Cover Photo"
                loading="lazy">
        </div>
    </div>
    @endif
    @php
    $left_ads = App\Models\ADS::where("is_active",1)->where("type","left_side")->get();
    $right_ads = App\Models\ADS::where("is_active",1)->where("type","right_side")->get();
    $center_ads = App\Models\ADS::where("is_active",1)->where("type","content_center")->get();
    @endphp
    <div class="row mt-4">

        <!-- Left Column (for Ads) -->
        @if($left_ads->count() > 0)
        <div class="col-md-2 d-none d-md-block" id="left-ads">
            <div class="card sticky-top">
                <div class="card-body">

                    <div id="leftAdCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($left_ads as $index => $ad)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$ad['image']) }}" class="d-block w-100" alt="Ad">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#leftAdCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#leftAdCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Middle Column (Shop Profile and About) -->
        <div id="center-content"
            class="{{ $left_ads->count() > 0 && $right_ads->count() > 0 ? 'col-md-8' : ($left_ads->count() > 0 || $right_ads->count() > 0 ? 'col-md-10' : 'col-md-12') }}">
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            @if($shop->profile_photo)
                            <img src="{{ asset('storage/' . $shop->profile_photo) }}"
                                class="rounded-circle border border-5 border-white" alt="Profile Photo"
                                style="width: 150px; height: 150px;" loading="lazy">
                            @endif
                            <h4 class="mt-3">{{ $shop->name }}</h4>
                            <p> <strong>Category : </strong><a href="/category/{{$shop->category->slug}}">
                                    {{ $shop->category->title }} </a> |
                                <strong>City : </strong> <a href="/region/{{$shop->category->slug}}">
                                    {{ $shop->city->name }} </a>
                                @if($shop->type)
                                | <strong>Type : </strong> <a href="#"> {{ $shop->type}} </a>

                                @endif
                            </p>

                            <p><strong>Address:</strong> {{ $shop->address }}</p>
                            <p>
                                @php
                                $contactItems = [];
                                @endphp

                                @foreach($socials as $social)
                                @if($social["account"] == "email")
                                @php
                                $contactItems[] = '<a href="mailto:' . $social[" link"] . '">' . $social["link"]
                                    . '</a>' ; @endphp @elseif($social["account"]=="phone" ) @php
                                    $contactItems[]='<a href="tel:' . $social["link"] . '">' . $social["link"] . '</a>'
                                    ; @endphp @endif @endforeach {!! implode(' , ', $contactItems) !!}
                                </p>

                            <p>
                                @foreach($socials as $social)
                                @if($social["account"] == "facebook")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-facebook"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "messenger")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-facebook-messenger"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "instagram")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "twitter")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "tiktok")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-tiktok"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "youtube")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-youtube"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "linkedin")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "pinterest")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-pinterest"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "viber")
                                <a href="viber://chat?number={{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-viber"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "wechat")
                                <a href="{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-weixin"></i>
                                </a> &nbsp;
                                @elseif($social["account"] == "telegram")
                                <a href="https://t.me/{{ $social['link'] }}" target="_blank">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                &nbsp;
                                @endif
                                @endforeach

                            </p>
                        </div>
                    </div>
                    <!-- Badges Section -->
                    <div class="d-flex justify-content-between">
                        <p><strong>Recommended:</strong>
                            @if($shop->is_recommended)
                            <span class="badge bg-primary">Yes</span>
                            @else
                            <span class="badge bg-secondary">No</span>
                            @endif
                        </p>
                        <p><strong>Verified:</strong>
                            @if($shop->is_verified)
                            <span class="badge bg-info">Verified</span>
                            @else
                            <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </p>
                    </div>
                    @if($shop->description)
                    <h5 class="card-title">About the Shop</h5>
                    <p class="card-text">{!! $shop->description !!}</p>
                    @endif
                    <!-- Google Map Section -->
                    @if($shop->latitude && $shop->longitude)
                    <div class="mt-4">
                        <h5>Location</h5>
                        <div id="map" style="height: 300px;">
                            <iframe
                                src="https://www.google.com/maps?q={{$shop->latitude}},{{$shop->longitude}}&z=15&output=embed"
                                style="width: 100%; height: 100%;" loading="lazy"></iframe>
                        </div>
                    </div>
                    @endif
                    <br>
                    <!--  Center ADS -->
                    <div id="bannerCarousel" class="carousel slide" data-mdb-ride="carousel" data-mdb-interval="3000">
                        <div class="carousel-inner">
                            @foreach($center_ads as $key => $ad)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <a href="{{ $ad['link'] }}" target="_blank">
                                    <img src="{{ asset('storage/'.$ad['image']) }}" class="d-block w-100" alt="{{ $ad['title'] }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-mdb-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-mdb-slide="next">
                        <i class="fas fa-chevron-right"></i>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                    <br>
                    <!-- Product Section -->
                     @if($products->count() > 0)
                    <div class="container mt-4">
                        <h2 class="mb-3">{{ $shop->name }} - Products</h2>
                        <div class="row">
                            @foreach($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow-sm">
                                        <img src="{{ asset('storage/'.$product->photo) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text text-muted">{{ $product->price }} MMK</p>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links('pagination::bootstrap-5') }} 
                        </div>
                    </div>
                    <hr>
                    @endif


                    <!-- Gallery -->
                    <div class="container mt-4">
                        <div class="row">
                            @foreach($shopGallerys as $index => $shopGallery)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('storage/'.$shopGallery->photo) }}" class="card-img-top fixed-height" alt="Gallery Image">
                                    </div>
                                </div>

                                @if(($index + 1) % 3 == 0) 
                                    </div><div class="row">
                                @endif
                            @endforeach
                        </div>
                    </div>




                </div>
            </div>
        </div>

          <!-- Right Column (for Ads) -->
          @if($right_ads->count() > 0)
        <div class="col-md-2 d-none d-md-block" id="right-ads">
            <div class="card sticky-top">
                <div class="card-body">
                 
                    <div id="rightAdCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($right_ads as $index => $ad)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$ad['image']) }}" class="d-block w-100" alt="Ad">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#rightAdCarousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#rightAdCarousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@extends('web.master')
@section('body')
@php
$left_ads = App\Models\ADS::where("is_active",1)->where("type","left_side")->get();
$right_ads = App\Models\ADS::where("is_active",1)->where("type","right_side")->get();
$center_ads = App\Models\ADS::where("is_active",1)->where("type","content_center")->get();
@endphp
<div class="container mt-5">
    <div class="row justify-content-center text-center">
        <!-- Category Title -->
        <div class="col-12">
            <h2 class="category-title">Feature Shops</h2>
        </div>


    </div>
    <div class="row mt-4">
        <!-- Shop List -->

        @foreach($feature_shops as $shop)
        <div class="col-md-4 mb-4">
            <div class="card shop-card h-100 d-flex flex-column">
                <!-- Shop Image at Top -->
                <img src="{{ asset('storage/'.$shop->profile_photo) }}" class="card-img-top shop-img"
                    alt="{{ $shop->name }}">

                <!-- Shop Info -->
                <div class="card-body d-flex flex-column flex-grow-1">
                    <h5 class="card-title">{{ $shop->name }}</h5>
                    <p class="card-text flex-grow-1">
                        <span><b>Address:</b> {{$shop->address}} </span>
                    </p>

                    <!-- Display Status Badges -->
                    <div class="status-badges">
                        @if($shop->is_recommanded)
                        <span class="badge bg-success animated-badge"><i class="fas fa-star"></i> Recommended</span>
                        @endif
                        @if($shop->is_verified)
                        <span class="badge bg-info animated-badge"><i class="fas fa-check-circle"></i> Verified</span>
                        @endif
                        @if($shop->is_featured)
                        <span class="badge bg-warning animated-badge"><i class="fas fa-fire"></i> Featured</span>
                        @endif
                    </div>

                    <!-- Location & Category Badges -->
                    <div class="mt-2">
                        <span class="badge bg-secondary"><i class="fas fa-map-marker-alt"></i>
                            {{ $shop->city->name }}</span>
                        <span class="badge bg-primary"><i class="fas fa-tags"></i> {{ $shop->category->title }}</span>
                    </div>

                    <!-- View Details Button -->
                    <div class="mt-auto">
                        <a href="/shop/{{$shop->slug}}" class="btn btn-primary mt-3 w-100">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

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
    </div>

    <div class="row justify-content-center text-center">
        <!-- Category Title -->
        <div class="col-12">
            <h2 class="category-title">Other Shops</h2>
        </div>


    </div>

    <div class="row mt-4">
        <!-- Shop List -->

        @foreach($other_shops as $shop)
        <div class="col-md-4 mb-4">
            <div class="card shop-card h-100 d-flex flex-column">
                <!-- Shop Image at Top -->
                <img src="{{ asset('storage/'.$shop->profile_photo) }}" class="card-img-top shop-img"
                    alt="{{ $shop->name }}">

                <!-- Shop Info -->
                <div class="card-body d-flex flex-column flex-grow-1">
                    <h5 class="card-title">{{ $shop->name }}</h5>
                    <p class="card-text flex-grow-1">
                        <span><b>Address:</b> {{$shop->address}} </span>
                    </p>

                    <!-- Display Status Badges -->
                    <div class="status-badges">
                        @if($shop->is_recommanded)
                        <span class="badge bg-success animated-badge"><i class="fas fa-star"></i> Recommended</span>
                        @endif
                        @if($shop->is_verified)
                        <span class="badge bg-info animated-badge"><i class="fas fa-check-circle"></i> Verified</span>
                        @endif
                        @if($shop->is_featured)
                        <span class="badge bg-warning animated-badge"><i class="fas fa-fire"></i> Featured</span>
                        @endif
                    </div>

                    <!-- Location & Category Badges -->
                    <div class="mt-2">
                        <span class="badge bg-secondary"><i class="fas fa-map-marker-alt"></i>
                            {{ $shop->city->name }}</span>
                        <span class="badge bg-primary"><i class="fas fa-tags"></i> {{ $shop->category->title }}</span>
                    </div>

                    <!-- View Details Button -->
                    <div class="mt-auto">
                        <a href="/shop/{{$shop->slug}}" class="btn btn-primary mt-3 w-100">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

      
    </div>
</div>

<!-- CSS for Uniform Card Height & Styling -->
<style>
.shop-card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
}

.shop-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.shop-img {
    height: 220px;
    width: 100%;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

/* Badge Styling */
.badge {
    font-size: 14px;
    padding: 6px 12px;
    margin-right: 8px;
    margin-top: 10px;
    border-radius: 20px;
    font-weight: 600;
}

.status-badges .badge {
    transition: all 0.3s ease;
}

.status-badges .badge:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

/* Animation for badges */
.animated-badge {
    animation: bounceIn 0.5s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: translateY(-20px);
        opacity: 0;
    }

    60% {
        transform: translateY(10px);
        opacity: 1;
    }

    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.category-title {
    font-size: 32px;
    font-weight: bold;
    text-transform: uppercase;
    color: #333;
    letter-spacing: 1.5px;
    position: relative;
    display: inline-block;
    padding-bottom: 10px;
}

.category-title::after {
    content: "";
    width: 60px;
    height: 4px;
    background-color: #007bff;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    border-radius: 2px;
}
</style>
@endsection
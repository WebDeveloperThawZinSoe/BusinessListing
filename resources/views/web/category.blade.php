@extends('web.master')
@section('body')
<div class="container mt-5">
    <div class="row justify-content-center text-center">
        <!-- Category Title -->
        <div class="col-12">
            <h2 class="category-title">{{ $category->title }}</h2>
        </div>
        
        <!-- Category Description -->
        <div class="col-lg-8 col-md-10 col-sm-12">
            <p class="category-description">{!! $category->description !!}</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <!-- Shop List -->
        @foreach($shops as $shop)
        <div class="col-12 mb-4">
            <div class="card shop-card">
                <div class="row g-0">
                    <!-- Shop Profile Photo -->
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$shop->profile_photo) }}" class="card-img shop-img" alt="{{ $shop->name }}">
                    </div>
                    
                    <!-- Shop Info -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $shop->name }}</h5>
                            <p class="card-text">
                                <span><b>Address :: </b> {{$shop->address}} </span>
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

                            <!-- Location Badge -->
                            <span class="badge bg-secondary"> <i class="fas fa-map-marker-alt"></i> {{ $shop->city->name }}</span>
                            
                            <!-- Category Badge -->
                            <span class="badge bg-primary"> <i class="fas fa-tags"></i> {{ $shop->category->title }}</span>
                            <br>
                            <a href="/shop/{{$shop->slug}}" class="btn btn-primary mt-3">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

           <!-- Pagination -->
           <div class="d-flex justify-content-center mt-4">
            {{ $shops->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<style>
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

    .category-description {
        font-size: 18px;
        color: #555;
        line-height: 1.6;
        margin-top: 15px;
    }

    .shop-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .shop-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .shop-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border-radius: 10px 0 0 10px;
    }

    .card-title {
        font-weight: bold;
        font-size: 18px;
    }

    .card-text {
        font-size: 14px;
        color: #777;
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

    .bi {
        margin-right: 5px;
    }

    /* Animation for badges */
    .animated-badge {
        animation: bounceIn 0.5s ease-out;
    }

    @keyframes bounceIn {
        0% { transform: translateY(-20px); opacity: 0; }
        60% { transform: translateY(10px); opacity: 1; }
        100% { transform: translateY(0); opacity: 1; }
    }
</style>
@endsection

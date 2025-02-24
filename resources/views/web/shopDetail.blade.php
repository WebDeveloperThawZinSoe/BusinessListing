@extends('web.master')

@section('body')
<div class="container mt-5">
    <!-- Shop Profile Header Section (Facebook-like) -->
    @if($shop->cover_photo)
    <div class="row">
        <!-- Cover Photo Section -->
        <div class="col-12">
            <img src="{{ asset('storage/' . $shop->cover_photo) }}" class="img-fluid w-100"  alt="Cover Photo" loading="lazy">
        </div>
    </div>
    @endif

    <div class="row mt-4">
        <!-- Left Column (for Ads) -->
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Advertisement</h5>
                    <p>Place your ads here.</p>
                </div>
            </div>
        </div>

        <!-- Middle Column (Shop Profile and About) -->
        <div class="col-md-8">
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
                            <p> <strong>Category : </strong><a href="/category/{{$shop->category->slug}}"> {{ $shop->category->title }} </a> |  
                                <strong>City : </strong> <a href="/region/{{$shop->category->slug}}"> {{ $shop->city->name }} </a> 
                                @if($shop->type)
                            | <strong>Type : </strong> <a href="#"> {{ $shop->type}} </a>

                            @endif
                            </p>

                            <p><strong>Address:</strong> {{ $shop->address }}</p>
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
                            <iframe src="https://www.google.com/maps?q={{$shop->latitude}},{{$shop->longitude}}&z=15&output=embed" 
                                    style="width: 100%; height: 100%;" loading="lazy"></iframe>
                        </div>
                    </div>
                    @endif
                    

                   

                </div>
            </div>
        </div>

        <!-- Right Column (for Ads) -->
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Advertisement</h5>
                    <p>Place your ads here.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

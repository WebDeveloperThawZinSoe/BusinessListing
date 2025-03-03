@extends('web.master')
@section('body')
<div class="container mt-3">
    <div class="row">
        @foreach($cities as $city)
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-3">
            <a href="/region/{{ $city->slug }}" class="text-decoration-none">
                <div class="card city-card position-relative">
                    <img src="{{ asset('storage/'.$city->icon) }}" class="card-img-top city-img"
                        alt="{{ $city->name }}">

                    <!-- Always visible small city name -->
                    <div class="small-city-name">{{ $city->name }}</div>

                    <!-- Overlay on hover -->
                    <div class="card-overlay">
                        <h5 class="text-white text-center">{{ $city->name }}</h5>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

       
    </div>
</div>


<style>
.city-card {
    overflow: hidden;
    border-radius: 10px;
    transition: transform 0.3s;
    height: 250px;
    /* Set a uniform height */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.city-img {
    object-fit: cover;
    height: 100%;
    width: 100%;
}

.city-card:hover {
    transform: scale(1.05);
}

/* Small city name (always visible) */
.small-city-name {
    position: absolute;
    bottom: 8px;
    left: 12px;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 4px 8px;
    font-size: 14px;
    border-radius: 4px;
    transition: opacity 0.3s;
}

/* Hover overlay */
.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s;
}

/* Hide small city name when hovered */
.city-card:hover .small-city-name {
    opacity: 0;
}

/* Show overlay when hovered */
.city-card:hover .card-overlay {
    opacity: 1;
}
</style>
@endsection
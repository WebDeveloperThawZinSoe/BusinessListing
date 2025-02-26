@extends('web.master')
@section('body')
<div class="container mt-3">
    <div class="row">
        @if($categories->count() > 0)
        @foreach($categories as $category)
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 d-flex justify-content-center mt-4 mb-4">
                <a href="/category/{{ $category->slug }}" class="text-decoration-none">
                    <div class="text-center">
                        <div class="card border-0 shadow-lg d-flex align-items-center justify-content-center"
                            style="border-radius: 50%; width: 180px; height: 180px; overflow: hidden; padding: 15px; background: white;">
                            <img src="{{ asset('storage/'.$category->icon) }}" class="card-img-top" alt="{{ $category->name }}"
                                style="object-fit: cover; height: 100%; width: 100%; border-radius: 50%;">
                        </div>
                        <h5 class="card-title mt-3" style="font-size: 1.0rem; font-weight: bold; color: #333;">
                            {{ $category->title }}
                        </h5>
                    </div>
                </a>
            </div>
        @endforeach

        @else
        <h3 class="text-center mt-3 w-100">No Category Yet...</h3>
        @endif
    </div>
</div>
@endsection

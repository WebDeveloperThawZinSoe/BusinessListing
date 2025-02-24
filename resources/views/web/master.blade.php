@php
$banner_ads = App\Models\ADS::where("is_active",1)->where("type","banner")->get();
$footer_ads = App\Models\ADS::where("is_active",1)->where("type","footer")->get();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME')}}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-2">
        <div class="container">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-mdb-toggle="offcanvas" data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto d-none d-lg-flex gap-3">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('region')}}">Regions</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('shops')}}">Shops</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('faq')}}">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact</a></li>
                </ul>
                <ul class="navbar-nav d-none d-lg-flex">
                    @guest
                    <li class="nav-item"><a class="btn btn-secondary me-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item"><a class="btn btn-primary"
                            href="{{ route('register') }}">Register</a></li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button"
                            data-mdb-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('routeCheck')}}">Dashboard</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ env('APP_NAME') }}</h5>
            <button type="button" class="btn-close text-reset" data-mdb-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('region')}}">Regions</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('shops')}}">Shops</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('faq')}}">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('contact')}}">Contact</a></li>
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="container mt-4">
        <div id="bannerCarousel" class="carousel slide" data-mdb-ride="carousel" data-mdb-interval="3000">
            <div class="carousel-inner">
                @foreach($banner_ads as $key => $ad)
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



        @yield('body')


        <div id="foooterCarousel" class="carousel slide mt-4" data-mdb-ride="carousel" data-mdb-interval="3000">
            <div class="carousel-inner">
                @foreach($footer_ads as $key => $ad)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <a href="{{ $ad['link'] }}" target="_blank">
                        <img src="{{ asset('storage/'.$ad['image']) }}" class="d-block w-100" alt="{{ $ad['title'] }}">
                    </a>
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#foooterCarousel" role="button" data-mdb-slide="prev">
                <i class="fas fa-chevron-left"></i>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#foooterCarousel" role="button" data-mdb-slide="next">
            <i class="fas fa-chevron-right"></i>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>



    <footer class="bg-dark text-white text-center text-lg-start mt-5">

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2025 {{ env('APP_NAME') }}. All rights reserved.
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

</body>

</html>
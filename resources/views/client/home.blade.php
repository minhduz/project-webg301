@extends('client.layouts.home-layout')

@section('title',"Home Page")

@section('login')
    @guest
        @if (Route::has('login'))
            <div class="header__top__right">
                <div class="header__top__right__auth">
                    <a href="{{route('login')}}"><i class="fas fa-user"></i>Login</a>
                </div>
            </div>
        @endif
    @else
    <div class="header__top__right">
        <div class="header__top__right__auth">
            <a href="#"><i class="fas fa-user"></i>{{ Auth::user()->name }}</a>
        </div>
        <div class="header__top__right__auth">
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
             </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>
        </div>
    </div>

    @endguest
@endsection

@section('hero')
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fas fa-bars"></i>
                        <span>All catalogs</span>
                    </div>
                    <ul>
                    @foreach ($filteredCatalogs as $catalog)
                        <li><a href="{{ route('catalog', ['id' => $catalog->catalog_id]) }}">{{$catalog->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="{{asset('images/banner.jpg')}}">
                    <div class="hero__text">
                        <span>FRUIT FRESH</span>
                        <h2>Vegetable <br />100% Organic</h2>
                        <p>Free Pickup and Delivery Available</p>
                        <a href="#" class="primary-btn">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
 <!-- Featured Section Begin -->
 <section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @foreach ($filteredCatalogs as $catalog)
                        <li data-filter=".catalog-{{$catalog->catalog_id}}">{{$catalog->name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @foreach ($filteredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix catalog-{{$product->catalog_id}}">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="{{asset('images/products/' . $product->main_image_url)}}">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="{{ route('detail', ['id' => $product->product_id]) }}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">{{$product->name}}</a></h6>
                            <h5>${{$product->price}}</h5>
                        </div>
                    </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->
@endsection

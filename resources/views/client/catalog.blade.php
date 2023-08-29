@extends('client.layouts.home-layout')

@section('title',$catalog->name . ' products')

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

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('images/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{$catalog->name}}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-7">
                <div class="row">
                    @foreach ($listProduct as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset('images/products/' . $product->main_image_url)}}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="{{ route('detail', ['id' => $product->product_id]) }}"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="#">{{$product->name}}</a></h6>
                                <h5>${{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection

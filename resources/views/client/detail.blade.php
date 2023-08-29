@extends('client.layouts.home-layout')

@section('title',$product[0]->name . ' detail')

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
    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large"
                                src="{{asset('images/products/' . $product[0]->main_image_url)}}" alt="">
                        </div>
                        <div class="product__details__subimages">
                            @foreach ($listImage as $image)
                                <img src="{{asset('images/products/' . $image->image_url)}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>{{$product[0]->name}}</h3>
                        <div class="product__details__price">${{$product[0]->price}}</div>
                        <p>
                            {{$product[0]->description}}
                        </p>
                        <form action="{{route('addToCart')}}" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="product_id" value="{{$product[0]->product_id}}"/>
                            <div class="product__details__quantity">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <span class="dec qtybtn">-</span>
                                        <input type="text" name="quantity" value="1">
                                        <span class="inc qtybtn">+</span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="primary-btn">ADD TO CARD</button>
                        </form>
                        <ul>
                            <li><b>Catalog</b><span>{{$product[0]->catalog_name}}</span></li>
                            <li><b>Availability</b>
                            <span>
                                @if ($product[0]->status === 1)
                                    In stock
                                @else
                                    Out of stock
                                @endif
                            </span></li>
                            <li><b>Weight</b> <span>{{$product[0]->weight}} kg</span></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->




    <script>
        // Lấy đối tượng input và nút trong phần pro-qty
        const inputElement = document.querySelector('.pro-qty input');
        const decButton = document.querySelector('.pro-qty .dec');
        const incButton = document.querySelector('.pro-qty .inc');

        // Sự kiện click nút -
        decButton.addEventListener('click', function() {
            const currentValue = parseInt(inputElement.value);
            if (currentValue > 1) {
                inputElement.value = currentValue - 1;
            }
        });

        // Sự kiện click nút +
        incButton.addEventListener('click', function() {
            const currentValue = parseInt(inputElement.value);
            inputElement.value = currentValue + 1;
        });
    </script>

@endsection

<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fas fa-envelope"></i>hello@colorlib.com</li>
                            <li>Free Shipping for all Order of $99</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">

                    @yield('login')

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('home')}}"><img src="{{asset('images/logo.png')}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="{{ route('home')}}">Home</a></li>
                        <li><a href="./shop-grid.html">Shop </a></li>
                        <li><a href="./blog.html">Blog</a></li>
                        <li><a href="./contact.html">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        @if(session()->has('cartItem'))
                        <li><a href="{{ route('cart')}}"><i class="fas fa-shopping-cart"></i><span>{{session('cartItem')}}</span></a></li>
                        @endif
                    </ul>

                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fas fa-bars"></i>
        </div>
    </div>
</header>

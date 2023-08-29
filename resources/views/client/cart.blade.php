@extends('client.layouts.home-layout')

@section('title',"Cart")

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
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listCart as $cart)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{asset('images/products/' . $cart->main_image_url)}}" alt="">
                                        <h5>{{$cart->name}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        {{$cart->price}}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <span class="dec qtybtn">-</span>
                                                <input type="text" value="{{$cart->quantity}}">
                                                <span class="inc qtybtn">+</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">

                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <span class="icon_close"></span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Total <span id="cartTotal"></span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->




    <script>
        // Lấy tất cả các phần tử có class "pro-qty" (các ô tăng giảm số lượng)
        const quantityInputs = document.querySelectorAll('.pro-qty input');
        const cartTotalElement = document.getElementById('cartTotal');

        let cartTotal = 0;

        // Lặp qua tất cả các ô tăng giảm số lượng và thêm sự kiện
        quantityInputs.forEach(input => {
            const decButton = input.parentElement.querySelector('.dec');
            const incButton = input.parentElement.querySelector('.inc');
            const priceCell = input.closest('tr').querySelector('.shoping__cart__price');
            const totalCell = input.closest('tr').querySelector('.shoping__cart__total');
            const pricePerProduct = parseFloat(priceCell.textContent); // Giá của mỗi sản phẩm

            // Sự kiện khi nút "-" được bấm
            decButton.addEventListener('click', () => {
                if (input.value > 1) {
                    input.value--;
                    updateTotalPrice();
                }
            });

            // Sự kiện khi nút "+" được bấm
            incButton.addEventListener('click', () => {
                input.value++;
                updateTotalPrice();
            });

            // Cập nhật tổng giá
            function updateTotalPrice() {
                const newTotal = (parseFloat(input.value) * pricePerProduct).toFixed(2);
                totalCell.textContent = `$${newTotal}`;
                calculateCartTotal()
            }

            // Cập nhật tổng tiền đơn hàng
            function calculateCartTotal() {
                cartTotal = 0;
                quantityInputs.forEach(input => {
                    const priceCell = input.closest('tr').querySelector('.shoping__cart__price');
                    const pricePerProduct = parseFloat(priceCell.textContent);
                    cartTotal += parseFloat(input.value) * pricePerProduct;
                });
                cartTotalElement.textContent = `$${cartTotal.toFixed(2)}`;
            }

            // Đảm bảo tổng giá khớp ban đầu
            updateTotalPrice();
        });
    </script>


@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\Orders;

class OrderController extends Controller
{

    public function __construct(){
        $this->product = new Products();
        $this->order = new Orders();
    }

    public function index(){
        $listCart = $this->order->getAllCart(Auth::user()->id);
        $cartItemCount = count($listCart);
        session()->flash('cartItem', $cartItemCount);
        return view('client.cart',compact('listCart'));
    }

    public function addToCart(Request $request){
        $order = $this->order->isHasCart(Auth::user()->id);

        if(is_null($order)){
            $order_id = $this->order->createCart(Auth::user()->id);

            $status=$this->order->addToCart([
                'quantity' => $request->quantity,
                'order_id' => $order_id,
                'product_id' => $request->product_id
            ]);
        }else{

            $order_details = $this->order->isHasProduct([
                'product_id' => $request->product_id,
                'order_id' => $order->order_id,
            ]);


            if(is_null($order_details)){
                $order = $this->order->isHasCart(Auth::user()->id);

                $status=$this->order->addToCart([
                    'quantity' => $request->quantity,
                    'order_id' => $order->order_id,
                    'product_id' => $request->product_id
                ]);
            }else{
                $cart = $this->order->isHasProduct([
                    'product_id' => $request->product_id,
                    'order_id' => $order->order_id
                ]);
                
                $order = $this->order->isHasCart(Auth::user()->id);
                $quantity = intval($request->quantity) + intval($cart->quantity);
                $status=$this->order->changeQuantity([
                    'quantity' => $quantity,
                    'product_id' => $request->product_id,
                    'order_id' => $order->order_id
                ]);
            }
        }

        return redirect()->route('cart');
    }


}

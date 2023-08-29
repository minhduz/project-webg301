<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Catalogs;
use App\Models\Products;
use App\Models\Images;
use App\Models\Orders;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->catalog = new Catalogs();
        $this->product = new Products();
        $this->image = new Images();
        $this->order = new Orders();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $listCatalog = $this->catalog->getAll();

        $listProduct = $this->product->getAll();

        //Lọc catalogs có status = 1
        $filteredCatalogs = collect($listCatalog)->where('status', 1)->all();

        // Lọc products có status = 1 và thuộc catalog có status = 1
        $filteredProducts = collect($listProduct)->filter(function ($product) use ($filteredCatalogs) {
            $catalog = collect($filteredCatalogs)->firstWhere('catalog_id', $product->catalog_id);
            return $product->status == 1 && $catalog && $catalog->status == 1;
        })->all();

        if(Auth::check()){
            $listCart = $this->order->getAllCart(Auth::user()->id);
            $cartItemCount = count($listCart);
            session()->flash('cartItem', $cartItemCount);
        }

        return view('client.home',compact('filteredCatalogs','filteredProducts'));
    }

    public function detail($id){
        $product=$this->product->getById($id);
        $listImage=$this->image->getByProduct($id);


        return view('client.detail',compact('product','listImage'));
    }
}

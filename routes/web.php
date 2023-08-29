<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ImageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::prefix('catalog')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('listCatalog', [CatalogController::class,'index'])->name('listCatalog');
    Route::post('addCatalog', [CatalogController::class,'store']);
    Route::put('editCatalog',[CatalogController::class,'update']);
    Route::delete('deleteCatalog',[CatalogController::class,'destroy']);
});

Route::prefix('product')->middleware(['auth','isAdmin'])->group(function(){
    Route::get('listProduct', [ProductController::class,'index'])->name('listProduct');
    Route::get('detail/{id?}', [ProductController::class,'show'])->name('productDetail');
    Route::post('addProduct', [ProductController::class,'store']);
    Route::get('edit/{id?}', [ProductController::class,'edit'])->name('editProduct');
    Route::put('edit/updateMainImage',[ProductController::class,'updateMainImage']);
    Route::put('edit/updateProduct',[ProductController::class,'update']);
    Route::delete('deleteProduct',[ProductController::class,'destroy']);
    Route::post('edit/addSubImage',[ImageController::class,'store']);
    Route::put('edit/updateSubImage',[ImageController::class,'update']);
    Route::delete('edit/deleteImage',[ImageController::class,'destroy']);
    Route::delete('edit/deleteAllImage',[ImageController::class,'destroyByProductId']);
});

Route::prefix('order')->middleware('auth')->group(function(){
    Route::get('cart', [OrderController::class, 'index'])->name('cart');
    Route::post('addToCart', [OrderController::class, 'addToCart'])->name('addToCart');
    Route::put('updateCart', [OrderController::class, 'updateCart'])->name('updateCart');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('detail/{id?}', [HomeController::class, 'detail'])->name('detail');
Route::get('catalog/{id?}', [ProductController::class, 'getByCatalog'])->name('catalog');

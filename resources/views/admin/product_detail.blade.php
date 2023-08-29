@extends('admin.layouts.admin-layout')

@section('title',$product[0]->name . ' detail')

@section('active-sidebar')
    <a href="{{ route('listCatalog') }}" class="nav-item nav-link"><i class="fas fa-clipboard-list me-2"></i>Catalog</a>
    <a href="{{ route('listProduct') }}" class="nav-item nav-link active"><i class="fas fa-cubes me-2"></i>Product</a>
    <a href="users.html" class="nav-item nav-link"><i class="fas fa-user me-2"></i>User</a>
    <a href="orders.html" class="nav-item nav-link"><i class="fas fa-shopping-cart me-2"></i>Order</a>
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-3">
                <img class="main_image" src="{{asset('images/products/' . $product[0]->main_image_url)}}" alt="">
            </div>
            <div class="col-sm-12 col-xl-9">
                <div class="bg-light rounded h-100 p-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Catalog</th>
                                <th scope="col">Price</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$product[0]->product_id}}</td>
                                <td>{{$product[0]->name}}</td>
                                <td>{{$product[0]->catalog_name}}</td>
                                <td>{{$product[0]->price}}</td>
                                <td>{{$product[0]->weight}}</td>
                                <td>
                                    @if ($product[0]->status === 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td colspan="5">
                                    {{$product[0]->description}}
                                </td>
                            </tr>
                            <tr>
                                <th>Action</th>
                                <td colspan="5">
                                    <a href="{{ route('listProduct')}}" class="btn btn-warning">Back</a>
                                    <a href="{{ route('editProduct', ['id' => $product[0]->product_id]) }}" class="btn btn-success">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xl-12">
                <div class="sub_images">
                    @foreach ($listImage as $image)
                        <img src="{{asset('images/products/' . $image->image_url)}}" alt="">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection


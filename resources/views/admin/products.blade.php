@extends('admin.layouts.admin-layout')

@section('title','Product')

@section('active-sidebar')
    <a href="{{ route('listCatalog') }}" class="nav-item nav-link"><i class="fas fa-clipboard-list me-2"></i>Catalog</a>
    <a href="{{ route('listProduct') }}" class="nav-item nav-link active"><i class="fas fa-cubes me-2"></i>Product</a>
    <a href="users.html" class="nav-item nav-link"><i class="fas fa-user me-2"></i>User</a>
    <a href="orders.html" class="nav-item nav-link"><i class="fas fa-shopping-cart me-2"></i>Order</a>
@endsection


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <h5>Add or Edit Product Falied</h5>
                    </div>
                    @foreach($errors->all() as $e)
                        <div class="alert alert-danger" role="alert">
                            <h5>{{$e}}</h5>
                        </div>
                    @endforeach
                @elseif(session()->has('msg'))
                    <div class="alert alert-{{ session('msg.color') }}" role="alert">
                        <h5>{{session('msg.text') }}</h5>
                    </div>
                @endif
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Product</h6>
                    <table class="table table-striped" id="product_table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Catalog</th>
                                <th scope="col">Main Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listProduct as $product)
                                <tr>
                                    <td>{{$product->product_id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->catalog_name}}</td>
                                    <td><img class="product_image" src="{{asset('images/products/' . $product->main_image_url)}}" ></td>
                                    <td>{{$product->price}}</td>
                                    <td>
                                        @if ($product->status === 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('productDetail', ['id' => $product->product_id]) }}" class="btn btn-warning">Detail</a>
                                        <a href="{{ route('editProduct', ['id' => $product->product_id]) }}" class="btn btn-success">Edit</a>
                                        <button class="btn btn-danger delete">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProduct">Create</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add')
<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addProduct" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label for="productName" class="form-label">Name</label></th>
                                <td><input type="text" class="form-control" name="name" id="productName"></td>
                            </tr>
                            <tr>
                                <th><label for="productPrice" class="form-label">Price</label></th>
                                <td>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="price" id="productPrice">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Catalog</th>
                                <td>
                                    <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" name="catalog_id">
                                        <option value="0">Choose a catalog ... </option>
                                        @foreach ($listCatalog as $catalog)
                                            <option value="{{$catalog->catalog_id}}">{{$catalog->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="productDescription" class="form-label">Description</label></th>
                                <td><textarea class="form-control" name="description" id="productDescription"></textarea></td>
                            </tr>
                            <tr>
                                <th><label for="productMainImage" class="form-label">Main Image</label></th>
                                <td><input class="form-control" type="file" name="main_image" id="productMainImage"></td>
                            </tr>
                            <tr>
                                <th><label for="productSubImages" class="form-label">Sub Images</label></th>
                                <td><input class="form-control" type="file" name="sub_images[]" id="productSubImages" multiple></td>
                            </tr>
                            <tr>
                                <th><label for="productWeight" class="form-label">Weight</label></th>
                                <td>
                                    <div class="input-group mb-3">
                                        <input type="number" step="0.01" class="form-control" name="weight" id="productWeight">
                                        <span class="input-group-text">kg</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="catalogName" class="form-label">Status</label></th>
                                <td>
                                    <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="1">
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                                        <label class="form-check-label" for="inactive">Inactive</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('delete')
<div class="modal fade" id="deleteProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="deleteProduct" method="POST">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" id="delete_productID"/>
                <div class="modal-body">
                    <p>Are you sure want to delete this Product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        var table = $('#product_table').DataTable({
            "pageLength": 5
        });

        table.on('click', '.delete',function(){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr=$tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            $('#delete_productID').val(data[0]);
            $('#deleteProduct').modal('show');
        });

    });


</script>
@endsection

@extends('admin.layouts.admin-layout')

@section('title','Edit ' . $product[0]->name)

@section('active-sidebar')
    <a href="{{ route('listCatalog') }}" class="nav-item nav-link"><i class="fas fa-clipboard-list me-2"></i>Catalog</a>
    <a href="{{ route('listProduct') }}" class="nav-item nav-link active"><i class="fas fa-cubes me-2"></i>Product</a>
    <a href="users.html" class="nav-item nav-link"><i class="fas fa-user me-2"></i>User</a>
    <a href="orders.html" class="nav-item nav-link"><i class="fas fa-shopping-cart me-2"></i>Order</a>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-8">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h5>Update Product Falied</h5>
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
                <h6 class="mb-4">Update Product</h6>
                <form action="updateProduct" method="POST">
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <table class="table">
                        <tr>
                            <th><label for="edit_productID" class="form-label">ID</label></th>
                            <td>
                                <input type="text" class="form-control" id="edit_productID" name="id" value="{{$product[0]->product_id}}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="productName" class="form-label">Product Name</label></th>
                            <td><input type="text" class="form-control" name="name" id="productName" value="{{$product[0]->name}}"></td>
                        </tr>
                        <tr>
                            <th><label for="productPrice" class="form-label">Price</label></th>
                            <td>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="price" id="productPrice" value="{{$product[0]->price}}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Catalog</th>
                            <td>
                                <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" name="catalog_id">
                                    @foreach ($listCatalog as $catalog)
                                        <option value="{{$catalog->catalog_id}}"
                                            {{ $catalog->catalog_id == $product[0]->catalog_id ? 'selected' : '' }}>
                                            {{$catalog->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="productDescription" class="form-label">Description</label></th>
                            <td><textarea class="form-control des" name="description" id="productDescription">{{$product[0]->description}}</textarea></td>
                        </tr>
                        <tr>
                            <th><label for="productMainImage" class="form-label">Main Image</label></th>
                            <td>
                                <img id="mainImage" class="product_image" src="{{asset('images/products/' . $product[0]->main_image_url)}}" alt="">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="productSubImages" class="form-label">Sub Images</label>
                                <br>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAllSubImage">Delete All</button>
                            </th>
                            <td>
                                <div class="sub_images">
                                    @foreach ($listImage as $image)
                                        <input type="hidden" class="subImageId" value="{{$image->image_id}}"/>
                                        <img class="subImage" src="{{asset('images/products/' . $image->image_url)}}" alt="">
                                    @endforeach
                                    <button type="button" class="btn btn-primary addSubImage" data-toggle="modal" data-target="#addSubImage">Add Sub Image</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="productWeight" class="form-label">Weight</label></th>
                            <td>
                                <div class="input-group mb-3">
                                    <input type="number" step="0.01" class="form-control" name="weight" id="productWeight" value="{{$product[0]->weight}}">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="catalogName" class="form-label">Status</label></th>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="active" value="1"
                                           <?php if ($product[0]->status == 1) echo "checked"; ?>>
                                    <label class="form-check-label" for="active">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="inactive" value="0"
                                           <?php if ($product[0]->status == 0) echo "checked"; ?>>
                                    <label class="form-check-label" for="inactive">Inactive</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <a href="{{ route('listProduct')}}" class="btn btn-warning">Back</a>
                            </th>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('add')
<!-- Add Sub Image Modal Start -->
<div class="modal fade" id="addSubImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new catalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addSubImage" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$product[0]->product_id}}"/>
                <input type="hidden" name="name" value="{{$product[0]->name}}"/>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label for="chooesFile" class="form-label">Choose file</label></th>
                                <td><input class="form-control" type="file" name="sub_images[]" id="chooesFile" multiple></td>
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
<!-- Add Sub Image Modal Start -->
@endsection

@section('edit')
<!-- Update Main Image Modal Start -->
<div class="modal fade" id="updateMainImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Main Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateMainImage" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$product[0]->product_id}}"/>
                <input type="hidden" name="name" value="{{$product[0]->name}}"/>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label class="form-label">Main Image</label></th>
                                <td><img class="product_image" id="mainImageOnModal" src="" alt=""></td>
                            </tr>
                            <tr>
                                <th><label for="chooesFile" class="form-label">Choose file</label></th>
                                <td><input class="form-control" type="file" name="main_image" id="chooesFile"></td>
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
<!-- Update Main Image Modal End  -->

<!-- Update Sub Image Modal End  -->
<div class="modal fade" id="updateSubImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Sub Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="updateSubImage" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$product[0]->product_id}}"/>
                <input type="hidden" name="name" value="{{$product[0]->name}}"/>
                <input type="hidden" name="image_id" id="editSubImageID" value=""/>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label class="form-label">Sub Image</label></th>
                                <td><img class="product_image" id="subImageOnModal" src="" alt=""></td>
                            </tr>
                            <tr>
                                <th><label for="chooesFile" class="form-label">Choose file</label></th>
                                <td><input class="form-control" type="file" name="sub_images" id="chooesFile"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteSubImage">Delete</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Update Sub Image Modal End  -->
@endsection

@section('delete')
<!-- Delete Sub Image Modal Start  -->
<div class="modal fade" id="deleteSubImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Sub Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="deleteImage" method="POST">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$product[0]->product_id}}"/>
                <input type="hidden" name="image_id" id="deleteSubImageID" value=""/>
                <div class="modal-body">
                    <p>Are you sure want to delete this Image?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Sub Image Modal End  -->

<!-- Delete All Sub Image Modal Start  -->
<div class="modal fade" id="deleteAllSubImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete All Sub Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="deleteAllImage" method="POST">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" value="{{$product[0]->product_id}}"/>
                <div class="modal-body">
                    <p>Are you sure want to delete all sub Images?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete All Sub Image Modal End  -->
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#mainImage').click(function(){
              // Get the source of the main image
            var mainImageSrc = $(this).attr('src');
            // Update the src attribute of the image in the modal
            $('#mainImageOnModal').attr('src', mainImageSrc)


            $('#updateMainImage').modal('show')
        });
    });

    $(document).ready(function(){
        $('.subImage').click(function(){
            var subImageId = $(this).prev('.subImageId').val();
            var subImageSrc = $(this).attr('src');

            $('#subImageOnModal').attr('src', subImageSrc)
            $('#editSubImageID').val(subImageId);
            $('#updateSubImage').modal('show')
        });
    });

    $(document).ready(function(){
    $('#deleteSubImage').click(function(){
        var imageId = $('#editSubImageID').val();

        $('#deleteSubImageID').val(imageId);
        $('#deleteSubImageModal').modal('show')
    });
});
</script>
@endsection

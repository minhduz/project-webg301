@extends('admin.layouts.admin-layout')

@section('title','Catalog')


@section('active-sidebar')
    <a href="{{ route('listCatalog') }}" class="nav-item nav-link active"><i class="fas fa-clipboard-list me-2"></i>Catalog</a>
    <a href="{{ route('listProduct') }}" class="nav-item nav-link"><i class="fas fa-cubes me-2"></i>Product</a>
    <a href="users.html" class="nav-item nav-link"><i class="fas fa-user me-2"></i>User</a>
    <a href="orders.html" class="nav-item nav-link"><i class="fas fa-shopping-cart me-2"></i>Order</a>
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <h5>Add or Edit Catalog Falied</h5>
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
                    <h6 class="mb-4">Catalog</h6>
                    <table class="table table-striped" id="catalog_table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCatalog as $catalog)
                                <tr>
                                    <td>{{ $catalog->catalog_id }}</td>
                                    <td>{{ $catalog->name }}</td>
                                    <td>
                                        @if ($catalog->status === 1)
                                            Active
                                        @else
                                            Inactive
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-success edit">Edit</button>
                                        <button class="btn btn-danger delete">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCatalog">Create</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('add')
<div class="modal fade" id="addCatalog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a new catalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="addCatalog" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label for="catalogName" class="form-label">Catalog Name</label></th>
                                <td>
                                    <input type="text" class="form-control" id="catalogName" name="name">
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

@section('edit')
<div class="modal fade" id="editCatalog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Catalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="editCatalog" method="POST">
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th><label for="edit_catalogID" class="form-label">ID</label></th>
                                <td>
                                    <input type="text" class="form-control" id="edit_catalogID" name="id" readonly>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="edit_catalogName" class="form-label">Catalog Name</label></th>
                                <td>
                                    <input type="text" class="form-control" id="edit_catalogName" name="name">
                                </td>
                            </tr>
                            <tr>
                                <th><label for="catalogName" class="form-label">Status</label></th>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="edit_active"
                                            value="1">
                                        <label class="form-check-label" for="edit_active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="edit_inactive"
                                            value="0">
                                        <label class="form-check-label" for="edit_inactive">Inactive</label>
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
<div class="modal fade" id="deleteCatalog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Catalog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="deleteCatalog" method="POST">
                <input type="hidden" name="_method" value="delete">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="id" id="delete_catalogID"/>
                <div class="modal-body">
                    <p>Are you sure want to delete this Catalog?</p>
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
        var table = $('#catalog_table').DataTable({
            "pageLength": 10
        });

        // Start edit record
        table.on('click', '.edit',function(){

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr=$tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#edit_catalogID').val(data[0]);
            $('#edit_catalogName').val(data[1]);

            let status = data[2];
            if(status=="Active"){
                $('#edit_active').prop('checked',true);
            }else{
                $('#edit_inactive').prop('checked',true);
            }

            $('#editCatalog').modal('show');
        });

        table.on('click', '.delete',function(){
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')){
                $tr=$tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            $('#delete_catalogID').val(data[0]);
            $('#deleteCatalog').modal('show');
        });
});
</script>
@endsection


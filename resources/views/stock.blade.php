@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.css">
    <style>
        .modal-dialog {
            max-width: 997px;
        }
    </style>
@endsection

@section('page-title')
    Stock - Stock Management
@endsection

@section('page-heading')
    <span class="badge badge-primary">Stock</span> -
    <small>Manage Stock</small>
@endsection

@section('main-content')
    @if(Session::has('message'))
        <div class="alert {{ Session::get('alert_type') }} alert-dismissible fade show" data-auto-dismiss>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ Session::get('message') }}.
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Manage Stock</h6>
            <a href="{{ route('stock.add') }}" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="icon">
                      <i class="fas fa-plus-square"></i>
                    </span>
                <span class="text">Add new Stock</span>
            </a>
        </div>

        <!--Stock Modal-->

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add-category"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">
                            <h5 id="exampleModalLabel"><span class="badge badge-primary">Stock Details</span></h5><small>Particular product information</small>
                        </div>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered product-table" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Product(Qty.)</th>
                                        <th>Available</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Price</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--/End Stock Modal-->

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->box_id }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td>{{ $purchase->created_at->format('d/m/Y - h:i a') }}</td>
                            <td class="d-flex">
                                <a href="#" class="btn btn-info btn-icon-split btn-sm mr-2" data-toggle="modal" data-target="#modal" onclick="getProducts({{ $purchase->box_id }})">
                                    <span class="icon">
                                      <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text">View</span>
                                </a>
                                <form id="delete-form" action="{{ route('category.delete' ) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $purchase->id }}">
                                    <button class="btn btn-danger btn-sm"
                                            onclick="if (!confirm('Are you sure to print!')) return false; "><i
                                                class="fas fa-print"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('admin') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin') }}/js/demo/datatables-demo.js"></script>

    <script>
        function getProducts(box_id) {
            $.get('stock/view/' + box_id)
                .done(function (data) {
                    var html = '';
                    data.forEach(function (product) {
                        html += '<tr>'
                        html += '<td>' + product.product_name + '</td>'
                        html += '<td>' + product.availableQty + '</td>'
                        html += '<td>' + product.category.name + '</td>'
                        html += '<td>' + product.brand.name + '</td>'
                        html += '<td>' + product.price + '</td>'
                        html += '<td>' + product.size + '</td>'
                        html += '<td>' + product.color + '</td>'
                        html += '<td>'
                        html += '<a href="stock/edit/'+ product.box_id +'" class="btn btn-warning btn-circle btn-sm mr-2 btnEdit" ><i class="fas fa-edit"></i></a>'
                        html += '<a href="stock/delete/'+ product.box_id +'" class="btn btn-danger btn-circle btn-sm mr-2 btnEdit" onclick="if(!confirm('+'Are you sure to delete?'+')) return false"><i class="fas fa-trash"></i></a>'
                        html += '</td> </tr>';
                    })
                    $('.product-table tbody').html(html)
                })
        }
    </script>
@endsection
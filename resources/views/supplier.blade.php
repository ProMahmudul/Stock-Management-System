@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection

@section('page-title')
    Suppliers - Stock Management
@endsection

@section('page-heading')
    <span class="badge badge-primary">Suppliers</span> -
    <small>Manage Suppliers</small>
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
            <h6 class="m-0 font-weight-bold text-primary">Manage supplier information</h6>
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modal" onclick="create()">
                    <span class="icon">
                      <i class="fas fa-plus-square"></i>
                    </span>
                <span class="text">Add new supplier</span>
            </a>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new supplier</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="myform" method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id">
                            <div class="form-group row">
                                <label for="type"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Select Type') }}</label>
                                <div class="col-md-6">
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Select --</option>
                                        <option value="0">Local</option>
                                        <option value="1">Export</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control" name="address">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="contact"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Contact') }}</label>
                                <div class="col-md-6">
                                    <input id="contact" type="number" class="form-control" name="contact">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total_balance"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Total Balance') }}</label>
                                <div class="col-md-6">
                                    <input id="total_balance" type="number" class="form-control" name="total_balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="paid" class="col-md-4 col-form-label text-md-right">{{ __('Paid') }}</label>
                                <div class="col-md-6">
                                    <input id="paid" type="number" class="form-control" name="paid">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>
                                <div class="col-md-6">
                                    <input id="image" type="file" class="form-control" name="image">
                                    <img src="" alt="" width="60">
                                </div>
                            </div>

                            <hr>

                            <div class="float-right">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary btnSave">Save
                                </button>
                                <button type="submit" class="btn btn-primary btnUpdate">Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>
                                @if(!empty($supplier->image))
                                    <img class="img" src="{{ Storage::url($supplier->image) }}" alt="" width="100">
                                @else
                                    {{ "Image not found!" }}
                                @endif
                            </td>
                            <td>
                                @if($supplier->type == 0)
                                    {{ "Local" }}
                                @elseif($supplier->type == 1)
                                    {{ "Export" }}
                                @endif
                            </td>
                            <td>{{ $supplier->contact }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>
                                @if($supplier->status == 1)
                                    <a href="{{ route('supplier.unpublished',$supplier->id ) }}"
                                       class="btn btn-success btn-icon-split btn-sm">
                    <span class="icon">
                      <i class="fas fa-check"></i>
                    </span>
                                        <span class="text">Active</span>
                                    </a>
                                @elseif($supplier->status == 0)
                                    <a href="{{ route('supplier.published',$supplier->id ) }}"
                                       class="btn btn-danger btn-icon-split btn-sm">
                    <span class="icon">
                      <i class="fas fa-times-circle"></i>
                    </span>
                                        <span class="text">Inactive</span>
                                    </a>
                                @endif
                            </td>
                            <td class="d-flex">
                                <a href="" class="btn btn-success btn-circle btn-sm mr-2 btnEdit" data-toggle="modal" data-target="#update-supplier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-form" action="{{ route('supplier.delete' ) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $supplier->id }}">
                                    <button class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure to delete?')) return false; "><i class="fas fa-trash"></i> </button>
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
        var modal = $('#modal');
        var btnSave = $('.btnSave');
        var btnUpdate = $('.btnUpdate');

        function create(){
            modal.find('.modal-title').text('Add new supplier')
            modal.find('#myform').attr('action', '{{ route('supplier.store') }}')
            modal.modal('show')
            btnSave.show()
            btnUpdate.hide()
        }

        $('table').on('click', '.btnEdit', function () {
            modal.find('.modal-title').text('Edit supplier information')
            modal.find('#myform').attr('action', '{{ route('supplier.update') }}')
            modal.modal('show')
            btnSave.hide()
            btnUpdate.show()

            var id = $(this).parent().parent().find('td').eq(0).text()
            var name = $(this).parent().parent().find('td').eq(1).text()
            var image = $(this).parent().parent().find('.img').attr('src')
            var type = $(this).parent().parent().find('td').eq(3).text()
            var contact = $(this).parent().parent().find('td').eq(4).text()
            var email = $(this).parent().parent().find('td').eq(5).text()
            var address = $(this).parent().parent().find('td').eq(6).text()

            $('#myform input[name="id"]').val(id)
            $('#myform input[name="name"]').val(name)
            $('#myform img').attr('src', image)
            $('#myform input[name="contact"]').val(contact)
            $('#myform input[name="email"]').val(email)
            $('#myform input[name="address"]').val(address)
        })
    </script>

@endsection
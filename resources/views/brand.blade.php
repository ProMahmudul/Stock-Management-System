@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection

@section('page-title')
    Brands - Stock Management
@endsection

@section('page-heading')
    <span class="badge badge-primary">Brands</span> -
    <small>Manage Brands</small>
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
            <h6 class="m-0 font-weight-bold text-primary">Manage brand information</h6>
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#modal"
               onclick="create()">
                    <span class="icon">
                      <i class="fas fa-plus-square"></i>
                    </span>
                <span class="text">Add new brand</span>
            </a>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="add-supplier"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new brand</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="myform" method="post">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required>
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if($brand->status == 1)
                                    <a href="{{ route('brand.unpublished',$brand->id ) }}"
                                       class="btn btn-success btn-icon-split btn-sm">
                    <span class="icon">
                      <i class="fas fa-check"></i>
                    </span>
                                        <span class="text">Active</span>
                                    </a>
                                @elseif($brand->status == 0)
                                    <a href="{{ route('brand.published',$brand->id ) }}"
                                       class="btn btn-danger btn-icon-split btn-sm">
                    <span class="icon">
                      <i class="fas fa-times-circle"></i>
                    </span>
                                        <span class="text">Inactive</span>
                                    </a>
                                @endif
                            </td>
                            <td class="d-flex">
                                <a href="" class="btn btn-warning btn-circle btn-sm mr-2 btnEdit" data-toggle="modal"
                                   data-target="#update-supplier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-form" action="{{ route('brand.delete' ) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $brand->id }}">
                                    <button class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure to delete!')) return false; "><i class="fas fa-trash"></i> </button>
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

        function create() {
            modal.find('.modal-title').text('Add new brand');
            modal.find('#myform').attr("action", "{{ route('brand.store') }}");
            modal.modal('show')
            btnSave.show()
            btnUpdate.hide()
        }

        $('table').on('click', '.btnEdit', function () {
            modal.find('.modal-title').text('Edit brand ');
            modal.find('#myform').attr("action", "{{ route('brand.update') }}");
            modal.modal('show')
            btnSave.hide()
            btnUpdate.show()

            var id = $(this).parent().parent().find('td').eq(0).text()
            var name = $(this).parent().parent().find('td').eq(1).text()

            $('#myform input[name="id"]').val(id)
            $('#myform input[name="name"]').val(name)
        });


    </script>
@endsection
@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin') }}/vendor/datatables/dataTables.bootstrap4.min.css">
    <style>
        .modal-dialog {
            /*max-width: 997px;*/
        }
    </style>
@endsection

@section('page-title')
    Payment - Stock Management
@endsection

@section('page-heading')
    <span class="badge badge-primary">Payment</span> -
    <small>Manage Payments</small>
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
            <h6 class="m-0 font-weight-bold text-primary">Manage Payments</h6>
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
                            <h5 id="exampleModalLabel"><span class="badge badge-primary">Stock Details</span></h5>
                            <small>Particular product information</small>
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

        <!--Payment Modal-->

        <div class="modal fade" id="payment-modal" tabindex="-1" role="dialog" aria-labelledby="payment-modal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><span
                                    class="badge badge-primary">Add new payment</span></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('payment.supplier') }}" id="myform" method="post">
                                @csrf
                                <input type="hidden" name="supplier">
                                <div class="form-group row">
                                    <label for="invoice_id"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Invoice ID') }}</label>
                                    <div class="col-md-6">
                                        <input id="invoice_id" type="text" class="form-control" name="invoice_id"
                                               value="" readonly="readonly" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Total') }}</label>
                                    <div class="col-md-6">
                                        <input id="total" type="text" class="form-control" name="total" value=""
                                               readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="paid"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Paid') }}</label>
                                    <div class="col-md-6">
                                        <input id="paid" type="text" class="form-control" name="paid" value=""
                                               readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="new_paid"
                                           class="col-md-4 col-form-label text-md-right">{{ __('New Paid') }}</label>
                                    <div class="col-md-6">
                                        <input id="new_paid" type="text" class="form-control" name="new_paid"
                                               onkeyup="getPaid()">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="payment_method"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Payment') }}</label>
                                    <div class="col-md-6">
                                        <select name="payment_method" id="payment_method" class="form-control">
                                            @foreach($payment_methods as $payment_methods)
                                                <option value="{{ $payment_methods->id }}">{{ $payment_methods->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="remarks"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Remarks') }}</label>
                                    <div class="col-md-6">
                                            <textarea name="remarks" id="remarks" class="form-control"
                                                      rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btnSave">Pay
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--/End Payment Modal-->

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Status</th>
                        <th>Total(Tk)</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Invoice</th>
                        <th>Status</th>
                        <th>Total(Tk)</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->box_id }}</td>
                            <td>
                                @if($purchase->status == 0)
                                    <span class="badge badge-danger">Unpaid</span>
                                @elseif($purchase->status == 1)
                                    <span class="badge badge-success">Paid</span>
                                @endif
                            </td>
                            <td>{{ $purchase->price }}</td>
                            <td>{{ $purchase->supplier->name }}</td>
                            <td class="d-flex">
                                <a href="#" class="btn btn-info btn-icon-split btn-sm mr-2" data-toggle="modal"
                                   data-target="#modal" onclick="getProducts({{ $purchase->box_id }})">
                                    <span class="icon">
                                      <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text">Details</span>
                                </a>
                                @if($purchase->status == 1)
                                    <a href="#" class="btn btn-success btn-icon-split btn-sm mr-2 disabled" data-toggle="modal"
                                       data-target="#payment-modal"
                                       onclick="addPayment({{ $purchase->box_id }}, {{ $purchase->price }}, {{ $purchase->supplier->id }} )">
                                    <span class="icon">
                                      <i class="fas fa-plus-circle"></i>
                                    </span>
                                        <span class="text">Pay</span>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-success btn-icon-split btn-sm mr-2" data-toggle="modal"
                                       data-target="#payment-modal"
                                       onclick="addPayment({{ $purchase->box_id }}, {{ $purchase->price }}, {{ $purchase->supplier->id }} )">
                                    <span class="icon">
                                      <i class="fas fa-plus-circle"></i>
                                    </span>
                                        <span class="text">Pay</span>
                                    </a>
                                @endif
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

        function addPayment(box_id, price, supplier_id) {
            $('input[name="invoice_id"]').val(box_id)
            $('input[name="total"]').val(price)
            $('input[name="supplier"]').val(supplier_id)

            $.get('payment/details/' + box_id)
                .done(function (data) {
                    var paid = 0;
                    data.forEach(function (payment) {
                        paid += payment.amount
                    })
                    $('input[name="paid"]').val(paid)
                })
        }

        function getPaid() {
            var new_paid = $('input[name="new_paid"]').val()
            var paid = $('input[name="paid"]').val()
            var paidTotal = parseInt(new_paid) + parseInt(paid);
            var total = $('input[name="total"]').val()

            if (paidTotal >= total) {
                alert("No need to pay more than " + total);
                $('input[name="new_paid"]').val(parseInt(total - paid))
            }
        }
    </script>
@endsection
@extends('layouts.master')

@section('page-title')
    Add Stock - Stock Management
@endsection

@section('page-heading')
    <span class="badge badge-primary">Stock</span> -
    <small>Add new products to stock</small>
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
    @php
        $boxID = \App\Purchase::select('box_id')->orderBy('box_id', 'DESC')->get();
        if (sizeof($boxID) == 0){
            $invoice_boxID = 55001;
        } else {
            $invoice_boxID = $boxID[0]->box_id + 1;
        }
    @endphp
    <div class="card card-body">
        <form action="{{ route('stock.save-purchase') }}" method="POST">
            @csrf
            <div class="row" class="bg-white">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="purchase_id" class="col-md-4 col-form-label text-md-left">Purchase ID</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="purchase_id" id="purchase_id"
                                   value="{{ $invoice_boxID }}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="supplier" class="col-md-4 col-form-label text-md-left">Supplier</label>
                        <div class="col-md-8">
                            <select name="supplier" id="supplier" class="form-control" required>
                                <option value="">-- Select --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand" class="col-md-4 col-form-label text-md-left">Brand</label>
                        <div class="col-md-8">
                            <select name="brand" id="brand" class="form-control" required>
                                <option value="">-- Select --</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="product" class="col-md-4 col-form-label text-md-left">Product</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="product" id="product" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="category" class="col-md-4 col-form-label text-md-left">Category</label>
                        <div class="col-md-8">
                            <select name="category" id="category" class="form-control" required>
                                <option value="">-- Select --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="size" class="col-md-4 col-form-label text-md-left">Size</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="size" id="size">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-md-4 col-form-label text-md-left">Color</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="color" id="color">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="quantity" class="col-md-4 col-form-label text-md-left">Qty</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="quantity" id="quantity">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-md-4 col-form-label text-md-left">Per Price</label>
                        <div class="col-md-8">
                            <input type="number" class="form-control" name="price" id="price">
                        </div>
                    </div>
                    <div class="form-group row float-right">
                        <input type="submit" class="btn btn-primary mr-3" value="Save">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
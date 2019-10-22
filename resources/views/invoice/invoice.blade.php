<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align:center
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

<div class="container clearfix" style="overflow: auto; clear: both">
    <div class="invoice-title" style="text-align: center">
        <h2 style="border: 1px solid #000; width: 400px; display: inline; line-height: 30px; padding: 15px;">Stock Invoice</h2>
    </div>
    <div class="row" >
        <div class="heder-left" style="float: left;">
            <h3>Company Name</h3>
            <p>John Doe, Mrs Emma Downson</p>
            <p>Acme Inc</p>
            <p>Berlin, Germany</p>
            <p>6781 45P</p>
        </div>

        <div class="text-right" style="float: right; clear:right">
            <p>Invoice # {{ $purchase->box_id }} </p>
            <p>Invoice Date: {{ $purchase->created_at->format('d-m-Y h:i a') }}</p>
            <h3>Bill To:</h3>
            <p>Supplier: {{ $purchase->supplier->name }}</p>
            <p>Address: {{ $purchase->supplier->address }}</p>
            <p>Contact: {{ $purchase->supplier->contact }}</p>
        </div>
    </div>
    <br>
    <div class="clearfix"></div>
    <div style="height: 30px;"></div>
    <div class="purchase-info">
        <table style="width:100%">
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Qty</th>
                <th>U.Price</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Due</th>
            </tr>
            <tr>
                <td>{{ $purchase->product->product_name }}</td>
                <td>{{ $purchase->product->category->name }}</td>
                <td>{{ $purchase->product->brand->name }}</td>
                <td>{{ $purchase->product->quantity }}</td>
                <td>{{ $purchase->product->price }}</td>
                <td>{{ $purchase->product->price * $purchase->product->quantity  }}</td>
                <td>{{ $payment  }}</td>
                <td>{{ $purchase->product->price * $purchase->product->quantity - $payment  }}</td>
            </tr>
        </table>
    </div>
    <div style="height: 50px;"></div>
    <div class="row">
        <div class="authorized-signature" style="text-align: center; float: left; width: 180px;">
            <p style="margin-bottom: 0">..........................................</p>
            <p style="margin-top: 0">Authorize Signature</p>
        </div>

        <div class="supplier-signature" style="text-align: center; float: right; width: 180px;">
            <p style="margin-bottom: 0">..........................................</p>
            <p style="margin-top: 0">Supplier Signature</p>
        </div>
    </div>
</div>

</body>
</html>

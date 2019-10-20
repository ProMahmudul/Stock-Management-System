<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use App\Purchase;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    public function index()
    {
        $brand = Brand::orderBy('name', 'ASC')->get();
        $category = Category::orderBy('name', 'ASC')->get();
        $supplier = Supplier::orderBy('id', 'DESC')->get();
        return view('add-purchase')->with(['brands' => $brand, 'categories' => $category, 'suppliers' => $supplier]);
    }

    public function save_purchase(Request $request){
        $product = new Product();

        $product->product_name = $request->product;
        $product->color = $request->color;
        $product->size = $request->size;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->availableQty = $request->quantity;
        $product->box_id = $request->purchase_id;
        $product->brand_id = $request->brand;
        $product->category_id = $request->category;
        $product->save();

        $purchase = new Purchase();

        $purchase->availableStock = $request->quantity;
        $purchase->price = ceil($request->quantity * $request->price);
        $purchase->box_id = $request->purchase_id;
        $purchase->supplier_id = $request->supplier;
        $purchase->save();

        $supplier = Supplier::find($request->supplier);
        $supplier->total_balance = $supplier->total_balance + ceil($request->quantity * $request->price);
        $supplier->save();

        Session::flash('message', 'Purchase successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('stock.add');
    }
}

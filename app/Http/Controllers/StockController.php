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

    public function save_purchase(Request $request)
    {
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

    public function manage()
    {
        $purchases = Purchase::orderBy('box_id', 'DESC')->get();
//        return $purchases;
        return view('stock', compact('purchases'));
    }

    public function stock_details($id)
    {
        return Product::where('box_id', $id)->with(['brand', 'category'])->get();
    }

    public function edit($id)
    {
        $products = Product::where('box_id', $id)->first();
        $suppliers = Supplier::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('edit-purchase')->with(['products' => $products, 'suppliers' => $suppliers, 'brands' => $brands, 'categories' => $categories]);
    }

    public function update(Request $request)
    {
//        return $request->all();
        $product = Product::where('box_id', $request->purchase_id)->first();

        $product->product_name = $request->product;
        $product->color = $request->color;
        $product->size = $request->size;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->availableQty = $request->availableQty;
        $product->brand_id = $request->brand;
        $product->category_id = $request->category;
        $product->save();

        $total = ceil($request->quantity * $request->price);
        $old_total = ceil($request->old_quantity * $request->old_price);

        $purchase = Purchase::where('box_id', $request->purchase_id)->first();
        $purchase->availableStock = $purchase->availableStock - ($request->old_quantity - $request->quantity);
        $purchase->price = $purchase->price - ($old_total - $total);
        $purchase->save();

        $supplier = Supplier::find($request->supplier);
        $supplier->total_balance = $supplier->total_balance - (($old_total - $total));
        $supplier->save();

        Session::flash('message', 'Purchase updated successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('stock.manage');
    }

    public function delete($id)
    {
        $purchase = Purchase::where('box_id', $id)->first();
        $product = Product::where('box_id', $id)->first();
        $purchase->supplier->total_balance = $purchase->supplier->total_balance - $purchase->price;
        $purchase->supplier->save();
        $purchase->delete();
        $product->delete();
        Session::flash('message', 'Purchase delete successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('stock.manage');
    }
}

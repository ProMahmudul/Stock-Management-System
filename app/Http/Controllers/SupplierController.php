<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'DESC')->get();
        return view('supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|boolean',
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $supplier = new Supplier();
        $supplier->type = $request->type;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->contact = $request->contact;
        $supplier->email = $request->email;
        $supplier->total_balance = $request->total_balance;
        $supplier->paid = $request->paid;
        $supplier->email = $request->email;

        if ($request->hasFile('image')) {
            $supplier->image = $request->image->store('public/supplier_image');
        }
        $supplier->save();

        Session::flash('message', 'Data Inserted successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('supplier');
    }

    public function unpublished($id)
    {
        $supplier = Supplier::find($id);
        $supplier->status = 0;
        $supplier->save();
        Session::flash('message', $supplier->name . ' is inactive now.');
        Session::flash('alert_type', 'alert-danger');
        return redirect()->route('supplier');
    }

    public function published($id)
    {
        $supplier = Supplier::find($id);
        $supplier->status = 1;
        $supplier->save();
        Session::flash('message', $supplier->name . ' is active now.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('supplier');
    }

    public function update(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->type = $request->type;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->contact = $request->contact;
        $supplier->email = $request->email;
        $supplier->total_balance = $request->total_balance;
        $supplier->paid = $request->paid;
        $supplier->email = $request->email;

        if ($request->hasFile('image')) {
            $supplier->image = $request->image->store('public/supplier_image');
        }
        $supplier->save();

        Session::flash('message', 'Supplier Updated successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('supplier');
    }

    public function delete(Request $request){
        $supplier = Supplier::find($request->id);
        $supplier->delete();
        Session::flash('message', $supplier->name . ' is deleted!');
        Session::flash('alert_type', 'alert-danger');
        return redirect()->route('supplier');
    }
}

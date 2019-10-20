<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('brand')->with('brands', $brands);
    }

    public function store(Request $request)
    {
        Brand::create($request->all());
        Session::flash('message', 'Brand added successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('brand');
    }

    public function unpublished($id)
    {
        $brand = Brand::find($id);
        $brand->status = 0;
        $brand->save();
        Session::flash('message', $brand->name . ' is inactive now.');
        Session::flash('alert_type', 'alert-danger');
        return redirect()->route('brand');
    }

    public function published($id)
    {
        $brand = Brand::find($id);
        $brand->status = 1;
        $brand->save();
        Session::flash('message', $brand->name . ' is active now.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('brand');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            $brand = Brand::find($request->id);
            $brand->update($request->all());
            Session::flash('message', $brand->name . ' is updated!');
            Session::flash('alert_type', 'alert-success');
            return redirect()->route('brand');
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $brand = Brand::find($request->id);
            $brand->delete();
            Session::flash('message', $brand->name . ' is deleted!');
            Session::flash('alert_type', 'alert-success');
            return redirect()->route('brand');
        }
    }
}

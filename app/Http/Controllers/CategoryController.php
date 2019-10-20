<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('category')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        Category::create($request->all());
        Session::flash('message', 'Category added successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('category');
    }

    public function unpublished($id)
    {
        $category = Category::find($id);
        $category->status = 0;
        $category->save();
        Session::flash('message', $category->name . ' is inactive now.');
        Session::flash('alert_type', 'alert-danger');
        return redirect()->route('category');
    }

    public function published($id)
    {
        $category = Category::find($id);
        $category->status = 1;
        $category->save();
        Session::flash('message', $category->name . ' is active now.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('category');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            $category = Category::find($request->id);
            $category->update($request->all());
        }

        Session::flash('message', $category->name . ' is updated.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('category');
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $category = Category::find($request->id);
            $category->delete();
        }

        Session::flash('message', $category->name . ' is deleted.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('category');
    }
}

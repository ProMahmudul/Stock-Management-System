<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::orderBy('type', 'ASC')->get();
        return view('payment-method')->with('payment_methods', $payment_methods);
    }

    public function store(Request $request)
    {
        PaymentMethod::create($request->all());
        Session::flash('message', 'Payment method added successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('payment-method');
    }

    public function unpublished($id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->status = 0;
        $payment_method->save();
        Session::flash('message', $payment_method->name . ' is inactive now.');
        Session::flash('alert_type', 'alert-danger');
        return redirect()->route('payment-method');
    }

    public function published($id)
    {
        $payment_method = PaymentMethod::find($id);
        $payment_method->status = 1;
        $payment_method->save();
        Session::flash('message', $payment_method->name . ' is active now.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('payment-method');
    }

    public function update(Request $request)
    {
        if ($request->has('id')) {
            $payment_method = PaymentMethod::find($request->id);
            $payment_method->update($request->all());
        }

        Session::flash('message', $payment_method->name . ' is updated.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('payment-method');
    }

    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $payment_method = PaymentMethod::find($request->id);
            $payment_method->delete();
        }

        Session::flash('message', $payment_method->name . ' is deleted.');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('payment-method');
    }
}

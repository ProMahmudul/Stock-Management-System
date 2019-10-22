<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentMethod;
use App\Purchase;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PaymentController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('status', 'ASC')->get();
        $payment_methods = PaymentMethod::all();
        return view('payment')->with(['purchases' => $purchases, 'payment_methods' => $payment_methods]);
    }

    public function payment_details($id)
    {
        $payments = Payment::where('box_id', $id)->get();
        return $payments;
    }

    public function save_supplier_payment(Request $request)
    {
        $payment = new Payment();

        $payment->amount = $request->new_paid;
        $payment->supplier_id = $request->supplier;
        $payment->payment_method = $request->payment_method;
        $payment->box_id = $request->invoice_id;
        $payment->remarks = $request->remarks;
        $payment->save();

        $supplier = Supplier::find($request->supplier);
        Supplier::where('id', $request->supplier)
            ->update(['paid' => $supplier->paid + $request->new_paid]);

        $total_paid = $request->paid + $request->new_paid;
        if ($request->total == $total_paid) {
            Purchase::where('box_id', $request->invoice_id)->update(['status' => 1]);
        } else {
            Purchase::where('box_id', $request->invoice_id)->update(['status' => 0]);
        }

        Session::flash('message', 'payment successfully!');
        Session::flash('alert_type', 'alert-success');
        return redirect()->route('payment');
    }
}

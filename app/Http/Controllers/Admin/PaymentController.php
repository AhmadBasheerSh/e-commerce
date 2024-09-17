<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderByDesc('id')->paginate(5);

        return view('admin.payments.index', compact('payments'));
    }

    public function destroy($id)
    {
        Payment::destroy($id);

        return redirect()->route('admin.payments.index')->with('msg', 'Payment deleted successfully')->with('type', 'danger');
    }
}

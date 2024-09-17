<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderByDesc('id')->paginate(5);

        return view('admin.orders.index', compact('orders'));
    }

    public function destroy($id)
    {
        Order::destroy($id);

        return redirect()->route('admin.orders.index')->with('msg', 'Orders deleted successfully')->with('type', 'danger');
    }
}

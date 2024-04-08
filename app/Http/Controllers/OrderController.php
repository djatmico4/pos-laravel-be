<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //index
    public function index()
    {
        $orders = Order::with('kasir')->orderBy('created_at', 'desc')->paginate(10);

        return view('pages.orders.index', compact('orders'));
    }

    //view
    public function show($id)
    {
        $order = Order::with('kasir')->findOrFail($id);

        //order items
        $orderItems = OrderItem::with('product')->where('order_id', $id)->get();

        return view('pages.orders.view', compact('order', 'orderItems'));
    }
}

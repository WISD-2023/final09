<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminMoneyController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        // 已完成訂單status = 5
        $completedOrders = Order::where('status', 5)->orderBy('id', 'ASC')->paginate($perPage);;

        // 總收益計算
        $totalProfit = 0;

        foreach ($completedOrders as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                $product = $orderDetail->product;
                $platformFee = $product->price * 0.05 * $orderDetail->quantity;
                $totalProfit += $platformFee;
            }
        }
        $data = ['totalProfit' => $totalProfit, 'orders' => $completedOrders];
        return view('admins.moneys.index', $data);
    }
}

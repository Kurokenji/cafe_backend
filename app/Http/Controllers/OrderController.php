<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Tạo order với trạng thái pending
        $order = Order::create([
            'table' => $request->table,
            'status' => 'pending',
            'total_price' => 0, // Khởi tạo total_price
        ]);

        $totalPrice = 0;

        foreach ($request->items as $item) {
            $itemModel = \App\Models\Item::find($item['item_id']);
            $subTotal = $itemModel->price * $item['quantity'];
            $totalPrice += $subTotal;

            // Lưu order_item, không lưu total_price
            $order->order_items()->create([
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
                // 'subtotal' => $subTotal, // Lưu giá từng món nếu cần
            ]);
        }

        // Cập nhật total_price vào orders
        $order->update(['total_price' => $totalPrice]);

        // Gửi sự kiện Pusher
        event(new NewOrder($order->load('order_items.item')));

        return response()->json(['message' => 'Order placed successfully']);
    }

    public function getOrders()
    {
        return response()->json(Order::with('order_items.item')->get());
    }

    public function prepareOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Order is not pending'], 400);
        }
        $order->update(['status' => 'preparing']);
        return response()->json([
            'message' => 'Order confirmed successfully',
            'order' => $order->load('order_items.item'),
        ]);
    }

    public function startDelivery($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'preparing') {
            return response()->json(['message' => 'Order is not preparing'], 400);
        }
        $order->update(['status' => 'delivering']);
        return response()->json([
            'message' => 'Delivery started successfully',
            'order' => $order->load('order_items.item'),
        ]);
    }

    public function completeDelivery($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'delivering') {
            return response()->json(['message' => 'Order is not delivering'], 400);
        }
        $order->update(['status' => 'delivered']);
        return response()->json([
            'message' => 'Delivery completed successfully',
            'order' => $order->load('order_items.item'),
        ]);
    }

    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'delivered') {
            return response()->json(['message' => 'Order is not delivered'], 400);
        }
        $order->update(['status' => 'paid']);
        return response()->json([
            'message' => 'Order marked as paid',
            'order' => $order->load('order_items.item'),
        ]);
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'cancelled']);
        return response()->json([
            'message' => 'Order cancelled successfully',
            'order' => $order->load('order_items.item'),
        ]);
    }
}
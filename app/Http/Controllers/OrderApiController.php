<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderApiController extends Controller
{
    // Список замовлень
    public function index(Request $request)
    {
        $orders = Order::filter($request->all())
            ->where('user_id', Auth::id()) // Показувати лише замовлення поточного користувача
            ->paginate(10);

        return response()->json($orders);
    }

    // Створити нове замовлення
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', array_column(Status::cases(), 'value')),
        ]);

        $validated['user_id'] = Auth::id();

        $order = Order::create($validated);

        return response()->json($order, 201);
    }

    // Показати одне замовлення
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order);
    }

    // Оновити замовлення
    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', array_column(Status::cases(), 'value')),
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    // Видалити замовлення
    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}

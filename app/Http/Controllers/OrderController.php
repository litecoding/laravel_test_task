<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Показати список замовлень
    public function index(Request $request)
    {
        $orders = Order::filter($request->all())->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Показати форму для створення
    public function create()
    {
        return view('orders.create');
    }

    // Зберегти нове замовлення
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', array_column(Status::cases(), 'value')),
        ]);

        $validated['user_id'] = Auth::id(); // Призначити поточного користувача

        Order::create($validated);

        // Отримуємо всі фільтри з запиту і виключаємо CSRF токен та HTTP метод
        $filters = $request->except('_token', '_method');

        return redirect()->route('orders.index', $filters)->with('success', 'Замовлення успішно створено!');
    }

    // Показати форму для редагування
    public function edit(Order $order)
    {
        $this->authorizeAction($order); // Перевірка, чи є доступ

        return view('orders.edit', compact('order'));
    }

    // Оновити замовлення
    public function update(Request $request, Order $order)
    {
        $this->authorizeAction($order); // Перевірка, чи є доступ

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', array_column(Status::cases(), 'value')),
        ]);

        $order->update($validated);

        // Отримуємо всі фільтри з запиту і виключаємо CSRF токен та HTTP метод
        $filters = $request->except('_token', '_method');

        return redirect()->route('orders.index', $filters)->with('success', 'Замовлення успішно оновлено!');
    }

    // Видалити замовлення
    public function destroy(Order $order, Request $request)
    {
        $this->authorizeAction($order); // Перевірка, чи є доступ

        $order->delete();

        // Отримуємо всі фільтри з запиту і виключаємо CSRF токен та HTTP метод
        $filters = $request->except('_token', '_method');

        return redirect()->route('orders.index', $filters)->with('success', 'Замовлення успішно видалено!');
    }

    // Додатковий метод для перевірки доступу до замовлення
    private function authorizeAction(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Ви не можете виконувати цю дію для цього замовлення.');
        }
    }
}

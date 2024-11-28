<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $orders = Order::latest()->whereUserId(Auth::id())->paginate(5)->withQueryString();

        return view('orders.index', compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): RedirectResponse
    {
        Order::create($request->validated() + ['user_id' => auth()->id()]);

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        return view('orders.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        return view('orders.edit',compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());

        return redirect()->route('orders.index')
            ->with('success','Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success','Order deleted successfully');
    }
}

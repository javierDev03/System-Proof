<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{

    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);

        return Inertia::render('OrderDetail', [
            'order' => $order
        ]);
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return Inertia::render('Orders/Create', [
            'customers' => $customers,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.product_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'number' => $request->number,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
        ]);

        foreach ($request->items as $item) {
            $product = Product::firstOrCreate([
                'name' => $item['product_name'],
                'price' => $item['product_price']
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['product_price'],  
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Orden creada con éxito');
    }

    
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('dashboard')->with('status', 'Orden cancelada');
    }
}

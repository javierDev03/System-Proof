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

    // Mostrar el formulario para crear una nueva orden
    public function create()
    {
        // Obtener todos los clientes y productos para mostrarlos en el formulario
        $customers = Customer::all();
        $products = Product::all();

        return Inertia::render('Orders/Create', [
            'customers' => $customers,
            'products' => $products
        ]);
    }

    // Almacenar una nueva orden
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'number' => 'required|string|max:255',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.product_price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Crear la orden
        $order = Order::create([
            'number' => $request->number,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
        ]);

        // Crear los items de la orden
        foreach ($request->items as $item) {
            // Verificar si el producto ya existe, si no, crear uno nuevo
            $product = Product::firstOrCreate([
                'name' => $item['product_name'],
                'price' => $item['product_price']
            ]);

            // Crear el item de la orden con el producto recién creado o existente
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['product_price'],  // El precio del producto, que es el que se usará en la orden
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Orden creada con éxito');
    }

    // Cancelar una orden
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('dashboard')->with('status', 'Orden cancelada');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CustomerController extends Controller
{


    public function create()
    {
        return Inertia::render('Customers/CustomerCreate');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:15',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.create')->with('success', 'Cliente creado exitosamente');
    }
}

<?php



namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $orders = Order::with('customer')->get();

        return Inertia::render('Dashboard', [
            'orders' => $orders
        ]);
    }
}

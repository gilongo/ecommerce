<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\Order\OrderResource;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        $orders = $query->paginate(10);

        return OrderResource::collection($orders);
    }
}

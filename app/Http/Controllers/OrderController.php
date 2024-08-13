<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
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

    public function show(Request $request, $order)
    {
        $order = Order::find($order);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return new OrderResource($order);
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total_price' => 0,
        ]);

        $totalPrice = 0;
        $products = [];
        foreach ($request->products as $product) {
            $dbProduct = Product::find($product['id']);
            
            if ($product['quantity'] > $dbProduct->quantity) {
                return response()->json(['error' => 'Insufficient stock'], 400);
            }

            $totalPrice += $dbProduct->promo_price ? $dbProduct->promo_price * $product['quantity'] : $dbProduct->price * $product['quantity'];

            $dbProduct->quantity -= $product['quantity'];
            $dbProduct->save();

            $products[] = [
                'order_id' => $order->id,
                'product_id' => $dbProduct->id,
                'quantity' => $product['quantity']
            ];
        }

        $order->total_price = $totalPrice;
        $order->save();
        $order->products()->attach($products);


        return new OrderResource($order);
    }
}

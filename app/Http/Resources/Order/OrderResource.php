<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Product\ProductResource;
use App\Models\Order;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => floatval($this->total_price),
            'created_at' => $this->created_at,
            'products' => $this->products->map(fn($product) => [
                'id' => $product->id,
                'quantity' => $product->pivot->quantity,
            ])
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('in_promo')) {

            $inPromo = filter_var($request->query('in_promo'), FILTER_VALIDATE_BOOLEAN);
            $query->where('in_promo', $inPromo);
        }

        $products = $query->paginate(10);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}

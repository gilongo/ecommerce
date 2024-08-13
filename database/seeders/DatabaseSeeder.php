<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = Category::factory(10)->create();

        Product::factory(40)->create()->each(function ($product) use ($categories) {
            $product->category_id = $categories->random()->id;
            $product->save();
        });

        Product::factory(10)->inPromo()->create()->each(function ($product) use ($categories) {
            $product->category_id = $categories->random()->id;
            $product->save();
        });

        User::factory(10)->create()->each(function ($user) {
            Order::factory(rand(1, 5))->create(
                [
                    'user_id' => $user->id
                ]
            )->each(function ($order) {
                $products = Product::inRandomOrder()->take(rand(1, 3))->get();
                $totalPrice = 0;
                
                foreach ($products as $product) {
                    $quantity = rand(1, 5);
                    $order->products()->attach($product->id, ['quantity' => $quantity]);

                    DB::table('products')->where('id', $product->id)->decrement('quantity', $quantity);
                    $totalPrice += $product->promo_price ? $product->promo_price * $quantity : $product->price * $quantity;
                }

                $order->update(['total_price' => $totalPrice]);
            });
        });
    }
}

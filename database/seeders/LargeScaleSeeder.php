<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Tenant;

class LargeScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding 650 tenants...');
        Tenant::factory()->count(650)->create();
        $this->command->info('Tenants seeded!');

        $this->command->info('Seeding 20,000 products...');
        
        // Chunking creation to avoid memory issues with large counts in one go
        $chunkSize = 1000;
        $total = 20000;
        
        for ($i = 0; $i < $total; $i += $chunkSize) {
            Product::factory()->count($chunkSize)->create();
            $this->command->info("Seeded products " . ($i + $chunkSize) . " / $total");
        }

        $this->command->info('Products seeded!');

        $this->command->info('Seeding e-commerce data (Clients, Carts, Purchases)...');
        
        $productIds = Product::pluck('id');

        Tenant::chunk(50, function ($tenants) use ($productIds) {
            foreach ($tenants as $tenant) {
                // Create Clients
                $clients = \App\Models\Client::factory(10)->create(['tenant_id' => $tenant->id]);

                foreach ($clients as $client) {
                    // Create Carts
                    $carts = \App\Models\Cart::factory(rand(1, 3))->create(['client_id' => $client->id]);

                    foreach ($carts as $cart) {
                        // Attach Products
                        $randomProducts = $productIds->random(rand(1, 5));
                        foreach ($randomProducts as $productId) {
                            $cart->products()->attach($productId, [
                                'price' => fake()->randomFloat(2, 10, 100),
                                'quantity' => rand(1, 3),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }

                        // Create Purchase if inactive
                        if (!$cart->is_active) {
                            $totalAmount = $cart->products()->sum(\Illuminate\Support\Facades\DB::raw('cart_products.price * cart_products.quantity'));
                            \App\Models\Purchase::factory()->create([
                                'cart_id' => $cart->id,
                                'total_amount' => $totalAmount,
                            ]);
                        }
                    }
                }
            }
        });

        $this->command->info('E-commerce data seeded!');
    }
}

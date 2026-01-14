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
        $tenantCount = 650;
        $productCount = 20000;

        $this->command->info("Seeding $tenantCount tenants...");
        Tenant::factory()->count($tenantCount)->create();
        $this->command->info('Tenants seeded!');

        $this->command->info("Seeding $productCount products...");
        
        // Chunking creation to avoid memory issues with large counts in one go
        $chunkSize = 1000;
        $total = $productCount;
        
        for ($i = 0; $i < $total; $i += $chunkSize) {
            Product::factory()->count($chunkSize)->create();
            $this->command->info("Seeded products " . ($i + $chunkSize) . " / $total");
        }

        $this->command->info('Products seeded!');

        // E-commerce Data Seeding - Bulk Insert Optimization
        $this->command->info('Seeding e-commerce data (Clients, Carts, Purchases)...');
        
        $productIds = Product::pluck('id')->toArray(); // Cache product IDs
        $tenantIds = Tenant::pluck('id')->toArray();
        $totalTenants = count($tenantIds);
        
        // Configuration
        $clientsPerTenant = 10;
        $batchSize = 50; // Process 50 tenants at a time
        
        $processed = 0;
        
        // Chunk the Tenant IDs array manually to control batching
        foreach (array_chunk($tenantIds, $batchSize) as $tenantIdChunk) {
            $clientData = [];
            $cartData = [];
            $cartProductData = [];
            $purchaseData = [];
            
            $now = now();
            
            // 1. Prepare Clients
            foreach ($tenantIdChunk as $tenantId) {
                for ($i = 0; $i < $clientsPerTenant; $i++) {
                    $clientData[] = [
                        'tenant_id' => $tenantId,
                        'name' => fake()->name(),
                        'email' => fake()->unique()->safeEmail(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            
            // Bulk Insert Clients
            \Illuminate\Support\Facades\DB::table('clients')->insert($clientData);
            
            // Retrieve newly created Client IDs to link Carts
            // Assumes sequential IDs. For robustness with UUIDs, we'd need a different approach, 
            // but for standard auto-increment in a focused seeder, fetching max ID or querying back is typical.
            // A safer way is to fetch clients for these tenants.
            $clients = \App\Models\Client::whereIn('tenant_id', $tenantIdChunk)->pluck('id')->toArray();
            
            // 2. Prepare Carts & Addresses
            $deliveryData = [];
            $paymentData = [];
            $cartData = [];

            foreach ($clients as $clientId) {
                // Generate Addresses
                $numAddresses = rand(1, 2);
                for ($a = 0; $a < $numAddresses; $a++) {
                    $deliveryData[] = [
                        'client_id' => $clientId,
                        'address_line1' => fake()->streetAddress(),
                        'address_line2' => rand(0, 1) ? fake()->secondaryAddress() : null,
                        'city' => fake()->city(),
                        'postal_code' => fake()->postcode(),
                        'country' => fake()->country(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    
                    $paymentData[] = [
                        'client_id' => $clientId,
                        'address_line1' => fake()->streetAddress(),
                        'address_line2' => rand(0, 1) ? fake()->secondaryAddress() : null,
                        'city' => fake()->city(),
                        'postal_code' => fake()->postcode(),
                        'country' => fake()->country(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                // Generate Carts
                $numCarts = rand(1, 3);
                for ($k = 0; $k < $numCarts; $k++) {
                    $cartData[] = [
                        'client_id' => $clientId,
                        'is_active' => (bool)rand(0, 1),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            
            // Bulk Insert Addresses
            \Illuminate\Support\Facades\DB::table('delivery_addresses')->insert($deliveryData);
            \Illuminate\Support\Facades\DB::table('payment_addresses')->insert($paymentData);

            // Fetch created Address IDs mapped by Client ID
            // Since we don't have IDs from insert, we fetch them back.
            // Assumption: client has addresses.
            $clientDeliveryAddressMap = \App\Models\DeliveryAddress::whereIn('client_id', $clients)
                ->select('id', 'client_id')
                ->get()
                ->groupBy('client_id');
                
            $clientPaymentAddressMap = \App\Models\PaymentAddress::whereIn('client_id', $clients)
                ->select('id', 'client_id')
                ->get()
                ->groupBy('client_id');

            // Bulk Insert Carts
            \Illuminate\Support\Facades\DB::table('carts')->insert($cartData);
            
            // Retrieve Carts for these clients
            $carts = \App\Models\Cart::whereIn('client_id', $clients)->get(); 
            // Use get() to check is_active for Purchases
            
            // 3. Prepare Cart Products & Purchases
            foreach ($carts as $cart) {
                $numProducts = rand(1, 5);
                $cartTotal = 0;
                
                for ($p = 0; $p < $numProducts; $p++) {
                    $prodId = $productIds[array_rand($productIds)];
                    $price = fake()->randomFloat(2, 10, 100);
                    $qty = rand(1, 3);
                    $lineTotal = $price * $qty;
                    $cartTotal += $lineTotal;
                    
                    $cartProductData[] = [
                        'cart_id' => $cart->id,
                        'product_id' => $prodId,
                        'price' => $price,
                        'quantity' => $qty,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                
                // Prepare Purchase if cart is not active (i.e. completed)
                if (!$cart->is_active) {
                    // Pick random address for this client
                    $clientId = $cart->client_id;
                    $delAddrId = $clientDeliveryAddressMap[$clientId]->random()->id ?? null;
                    $payAddrId = $clientPaymentAddressMap[$clientId]->random()->id ?? null;

                    $purchaseData[] = [
                        'cart_id' => $cart->id,
                        'total_amount' => $cartTotal,
                        'status' => 'completed',
                        'delivery_address_id' => $delAddrId,
                        'payment_address_id' => $payAddrId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            
            // Bulk Insert Pivot Data (Chunks of 1000 to be safe)
            foreach (array_chunk($cartProductData, 1000) as $chunk) {
                \Illuminate\Support\Facades\DB::table('cart_products')->insert($chunk);
            }
            
            // Bulk Insert Purchases
             foreach (array_chunk($purchaseData, 1000) as $chunk) {
                \Illuminate\Support\Facades\DB::table('purchases')->insert($chunk);
            }
            
            $processed += count($tenantIdChunk);
            $this->command->info("Seeded e-commerce data for $processed / $totalTenants tenants...");
        }

        $this->command->info('E-commerce data seeded!');
    }
}

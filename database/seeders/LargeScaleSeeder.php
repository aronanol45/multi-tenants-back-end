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
    }
}

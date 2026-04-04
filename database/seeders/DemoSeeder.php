<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure default tenant exists for FK integrity across seeds
        Tenant::firstOrCreate(['id' => 1], ['name' => 'Default Tenant']);

        $tenant = Tenant::firstOrCreate(['id' => 1], ['name' => 'Demo Store']);

        $cat = Category::firstOrCreate([
            'tenant_id' => $tenant->id,
            'name' => 'General',
        ], ['description' => 'Default category']);

        Product::firstOrCreate([
            'tenant_id' => $tenant->id,
            'sku' => 'MALT-330',
        ], [
            'category_id' => $cat->id,
            'name' => 'Super Malt (330ml)',
            'barcode' => '0123456789012', // NEW: sample barcode for scanning
            'price' => 450,
            'cost' => 300,
            'stock' => 24,
            'min_stock' => 6,
            'status' => 'active',
            'image_url' => null,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productAttribute = [
            ['id'=>1, 'product_id' => 1, 'size' => 'Small', 'sku' => 'BT00S', 'price' => 1000, 'status' => 1],
            ['id'=>2, 'product_id' => 1, 'size' => 'Mediul', 'sku' => 'BT00M', 'price' => 1200, 'status' => 1],
            ['id'=>3, 'product_id' => 1, 'size' => 'Large', 'sku' => 'BT00L', 'price' => 1400, 'status' => 1],
        ];
        ProductAttribute::insert($productAttribute);
    }
}

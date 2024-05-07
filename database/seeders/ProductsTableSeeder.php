<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsRecord = [
            ['id' => 1, 'category_id' => '2', 'brand_id' => '10', 'product_name' => 'Shirt', 'product_code' => 'shirt123', 'product_color' => 'navy blue', 'family_color' =>'Blue', 'group_code' => 'shirt', 'product_price' => 800.50, 'product_discount' => 100.50, 'discount_type' => 8.5, 'final_price' => 700.00, 'product_video' => 1, 'description' => 'test', 'wash_care' => '', 'keywords' => 'shirt', 'fabric' => '', 'pattern' => '', 'sleeve' => '', 'fit' => '', 'occassion' => '' , 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'is_featured' => 'yes', 'status' => 1],

            ['id' => 2, 'category_id' => '2', 'brand_id' => '20', 'product_name' => 'T-shirt', 'product_code' => 'tshirt123', 'product_color' => 'navy blue', 'family_color' =>'Blue', 'group_code' => 'tshirt', 'product_price' => 500.50, 'product_discount' => 100.50, 'discount_type' => 8.5, 'final_price' => 400.00, 'product_video' => 2, 'description' => 'test', 'wash_care' => '', 'keywords' => 'tshirt', 'fabric' => '', 'pattern' => '', 'sleeve' => '', 'fit' => '', 'occassion' => '' , 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'is_featured' => 'no', 'status' => 1],
        ];
        Product::insert($productsRecord);
    }
}

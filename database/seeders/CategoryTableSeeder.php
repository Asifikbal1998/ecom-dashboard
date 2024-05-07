<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryRecords = [
            ['id' => 1, 'parent_id' => 0, 'categori_name' => 'Clothing', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'clothing', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 2, 'parent_id' => 0, 'categori_name' => 'Electronics', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'electronics', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 3, 'parent_id' => 0, 'categori_name' => 'Appliances', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'appliances', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 4, 'parent_id' => 1, 'categori_name' => 'Men', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'men', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 5, 'parent_id' => 1, 'categori_name' => 'Women', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'women', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
            ['id' => 6, 'parent_id' => 1, 'categori_name' => 'Kids', 'categori_image' => '', 'categori_discount' => 0, 'description' => '', 'url' => 'kids', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1],
        ];
        Category::insert($categoryRecords);
    }
}

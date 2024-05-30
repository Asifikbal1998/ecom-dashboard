<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['id'=>1, 'brand_id'=>0, 'brand_name'=>'Fashion Flair', 'brand_image'=> '', 'brand_logo' =>'', 'brand_discount'=>300.00, 'description'=>'Desc', 'url'=>'', 'meta_title'=>'', 'meta_keywords'=> '', 'meta_description'=> '', 'website'=> '', 'email' =>'', 'phone' =>'', 'address' =>'', 'status' => 1],
            ['id'=>2, 'brand_id'=>0, 'brand_name'=>'Stardust Streetwear', 'brand_image'=> '', 'brand_logo' =>'', 'brand_discount'=>400.00, 'description'=>'Desc', 'url'=>'', 'meta_title'=>'', 'meta_keywords'=> '', 'meta_description'=> '', 'website'=> '', 'email' =>'', 'phone' =>'', 'address' =>'', 'status' => 1],
            ['id'=>3, 'brand_id'=>0, 'brand_name'=>'Modern Fashions', 'brand_image'=> '', 'brand_logo' =>'', 'brand_discount'=>500.00, 'description'=>'Desc', 'url'=>'', 'meta_title'=>'', 'meta_keywords'=> '', 'meta_description'=> '', 'website'=> '', 'email' =>'', 'phone' =>'', 'address' =>'', 'status' => 1]
        ];

        Brand::insert($brands);
    }
}

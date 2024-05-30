<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannersImage = [
            ['id' => 1, 'image' => '1.jpg', 'type' => 'banner', 'link' => '', 'title' => 'Banner', 'alt' => 'banner1', 'sort' => 1, 'status' => 1],
            ['id' => 2, 'image' => '2.jpg', 'type' => 'banner', 'link' => '', 'title' => 'Banner', 'alt' => 'banner2', 'sort' => 2, 'status' => 1],
        ];
        Banner::insert($bannersImage);
    }
}

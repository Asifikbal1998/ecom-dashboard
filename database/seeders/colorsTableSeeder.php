<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class colorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['id' => 1, 'color_name' => 'Black', 'color_code' => '#000000', 'status' => 1],
            ['id' => 2, 'color_name' => 'Blue', 'color_code' => '#0000FF', 'status' => 1],
            ['id' => 3, 'color_name' => 'Brown', 'color_code' => '#964B00', 'status' => 1],
            ['id' => 4, 'color_name' => 'Green', 'color_code' => '#008000', 'status' => 1],
            ['id' => 5, 'color_name' => 'Gray', 'color_code' => '#808080', 'status' => 1],
            ['id' => 6, 'color_name' => 'Multi', 'color_code' => '', 'status' => 1],
            ['id' => 7, 'color_name' => 'Olive', 'color_code' => '#808000', 'status' => 1],
            ['id' => 8, 'color_name' => 'Orange', 'color_code' => '#FFA500', 'status' => 1],
            ['id' => 9, 'color_name' => 'Pink', 'color_code' => '#FFC0CB', 'status' => 1],
            ['id' => 10, 'color_name' => 'Purple', 'color_code' => '#A020F0', 'status' => 1],
            ['id' => 11, 'color_name' => 'Red', 'color_code' => '#FF0000', 'status' => 1],
            ['id' => 12, 'color_name' => 'White', 'color_code' => '#FFFFFF', 'status' => 1],
            ['id' => 13, 'color_name' => 'Yellow', 'color_code' => '#FFFF00', 'status' => 1],
        ];

        Color::insert($colors);
    }
}

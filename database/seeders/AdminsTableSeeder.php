<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('12345678');
        $adminRecord = [
            ['id' => 1, 'name' => 'Admin', 'type' => 'admin', 'mobile' => '7584995504', 'email' => 'admin123@gmail.com', 'password' => $password, 'image' => '', 'status' => 1]
        ];
        Admin::insert($adminRecord);
    }
}

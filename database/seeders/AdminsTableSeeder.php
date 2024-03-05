<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('1234');
        $adminRecord = [
            ['id' => 2, 'name' => 'Juel Rana', 'type' => 'subadmin', 'mobile' => '6294374497', 'email' => 'juel123@gmail.com', 'password' => $password, 'image' => '', 'status' => 1],
            ['id' => 3, 'name' => 'Ikbal Asif', 'type' => 'subadmin', 'mobile' => '8694374497', 'email' => 'ikbal123@gmail.com', 'password' => $password, 'image' => '', 'status' => 1]
        ];
        Admin::insert($adminRecord);
    }
}

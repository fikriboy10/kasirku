<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'role'=>'admin',
                'password'=>bcrypt('admin123')
            ],
            [
                'name'=>'Kasir',
                'email'=>'kasir@gmail.com',
                'role'=>'kasir',
                'password'=>bcrypt('kasir123')
            ],
            [
                'name'=>'Owner',
                'email'=>'owner@gmail.com',
                'role'=>'owner',
                'password'=>bcrypt('owner123')
            ],
        ];

        foreach($userData as $key => $val) {
            User::create($val);
        }
    }
}

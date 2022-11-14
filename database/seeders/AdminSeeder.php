<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->delete();
        User::query()->create([
           'first_name' => 'Abdulrahem',
           'last_name' => 'Al-Zubi',
           'phone_number' => '0965237881',
           'email' => 'abdulrahemalz1@gmail.com',
           'password' => Hash::make('12345678'),
            'role_id' => 1
        ]);

    }
}

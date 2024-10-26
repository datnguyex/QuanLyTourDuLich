<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'test@gmail.com',
            'password' => Hash::make('Dat72@@##!!1'), // hoặc Hash::make('password123')
            'role' => 1,
        ]);
    }
}

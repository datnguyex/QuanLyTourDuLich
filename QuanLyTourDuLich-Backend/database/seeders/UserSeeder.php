<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo hoặc cập nhật nếu username đã tồn tại
        User::create([
            'name' => 'Toàn đẹp trai VIP promax',
            'username' => 'toanvip',
            'password' => Hash::make('password123'),
            'email' => 'toanvip@example.com',
            'role' => '1',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Hiệp đẹp trai',
            'username' => 'hiepvip',
            'password' => Hash::make('password123'),
            'email' => 'hiepvip@example.com',
            'role' => '2',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Đạt đẹp trai',
            'username' => 'datvip',
            'password' => Hash::make('password123'),
            'email' => 'datvip@example.com',
            'role' => '3',
            'email_verified_at' => now(),
        ]);
    }
}

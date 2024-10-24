<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Thêm dòng này
use Illuminate\Support\Facades\Hash; // Nếu bạn muốn sử dụng Hash cho mật khẩu

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa dữ liệu cũ (nếu cần)
        User::truncate();

        // Tạo người dùng mẫu
        User::create([
            
            'name' => 'Nguyễn Văn A',
            'username' => 'nguyenvana',
            'password' => bcrypt('password123'), // Mật khẩu được mã hóa
            'role' => 1, // Role là 1
           
        ]);

        User::create([
            
            'name' => 'Trần Thị B',
            'username' => 'tranthib',
            'password' => bcrypt('password456'), // Mật khẩu được mã hóa
            'role' => 2, // Role là 2
          
        ]);

        User::create([
           
            'name' => 'Lê Văn C',
            'username' => 'levanc',
            'password' => bcrypt('password789'), // Mật khẩu được mã hóa
            'role' => 3, // Role là 3
            
        ]);
    }
}

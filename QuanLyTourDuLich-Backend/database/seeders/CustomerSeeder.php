<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'contact_id' => 1,
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'gender' => 'male',
            'dob' => '1985-07-10',
            'type_customer' => 'self',
            'nationality' => 'Vietnam',
            'passport_number' => 'A1234567',
        ]);

        Customer::create([
            'contact_id' => 2,
            'name' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'gender' => 'female',
            'dob' => '1990-05-15',
            'type_customer' => 'self',
            'nationality' => 'Vietnam',
            'passport_number' => 'B7654321',
        ]);
    
    }
}

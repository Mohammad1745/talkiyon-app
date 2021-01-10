<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'email' => 'admin@example.com',
            'username' => 'admin11',
            'password' => Hash::make('123456789'),
            'phone' => '01857712135',
            'first_name' => 'Mr.',
            'last_name' => 'Admin',
            'role' => ADMIN_ROLE,
            'gender' => SEX_MALE,
            'status' => USER_ACTIVE_STATUS,
            'is_phone_verified' => true,
            'is_email_verified' => true,
        ]);
    }
}

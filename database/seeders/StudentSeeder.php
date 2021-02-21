<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'student1@example.com',
            'username' => 'student11',
            'password' => Hash::make('123456789'),
            'phone' => '01257712135',
            'first_name' => 'Mr.',
            'last_name' => 'Student1',
            'role' => STUDENT_ROLE,
            'gender' => SEX_MALE,
            'status' => USER_ACTIVE_STATUS,
            'is_phone_verified' => true,
            'is_email_verified' => true,
        ]);
        User::create([
            'email' => 'student2@example.com',
            'username' => 'student22',
            'password' => Hash::make('123456789'),
            'phone' => '01357712135',
            'first_name' => 'Mr.',
            'last_name' => 'Student2',
            'role' => STUDENT_ROLE,
            'gender' => SEX_MALE,
            'status' => USER_ACTIVE_STATUS,
            'is_phone_verified' => true,
            'is_email_verified' => true,
        ]);
        User::create([
            'email' => 'student3@example.com',
            'username' => 'student33',
            'password' => Hash::make('123456789'),
            'phone' => '01457712135',
            'first_name' => 'Mr.',
            'last_name' => 'Student3',
            'role' => STUDENT_ROLE,
            'gender' => SEX_MALE,
            'status' => USER_ACTIVE_STATUS,
            'is_phone_verified' => true,
            'is_email_verified' => true,
        ]);
    }
}

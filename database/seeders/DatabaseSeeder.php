<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    // // Call the Role and Permission Seeder first
    // $this->call(RolesAndPermissionsSeeder::class);

    // Create an Admin user
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'), 
    ]);
    $admin->assignRole('admin');

    // Create a Mentor user
    $mentor = User::create([
        'name' => 'Mentor User',
        'email' => 'mentor@example.com',
        'password' => Hash::make('password'),
    ]);
    $mentor->assignRole('mentor');

    // Create a Student user
    $student = User::create([
        'name' => 'Student User',
        'email' => 'student@example.com',
        'password' => Hash::make('password'),
    ]);
    $student->assignRole('student');

    
    }
}

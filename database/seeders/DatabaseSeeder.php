<?php

namespace Database\Seeders;

use App\Models\SecurityObject;
use App\Models\SecurityRole;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        SecurityObject::create([
            'name' => 'BackEnd',
            'url' => env('APP_URL') . 'admin/',
            'icon' => 'admin',
            'enable' => 1,
        ]);

        SecurityObject::create([
            'name' => 'FrontEnd',
            'url' => env('APP_URL'),
            'icon' => 'front',
            'enable' => 1,
        ]);

        SecurityRole::create([
            'name' => 'SuperAdmin',
            'security_object_id' => 1,
        ]);

        SecurityRole::create([
            'name' => 'Admin',
            'security_object_id' => 1,
        ]);

        SecurityRole::create([
            'name' => 'Manager',
            'security_object_id' => 1,
        ]);

        SecurityRole::create([
            'name' => 'Agent',
            'security_object_id' => 2,
        ]);


        User::create([
            'lastname' => 'SuperAdmin',
            'email' => 'superadmin@cecagadis.com',
            'phone' => '074228306',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'security_role_id' => 1,
        ]);

        User::create([
            'lastname' => 'Admin',
            'email' => 'admin@cecagadis.com',
            'phone' => '074228306',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'security_role_id' => 2,
        ]);

        User::create([
            'lastname' => 'Manager',
            'email' => 'manager@cecagadis.com',
            'phone' => '074228306',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'security_role_id' => 3,
        ]);

        User::create([
            'lastname' => 'Agent',
            'email' => 'superviseur@cecagadis.com',
            'phone' => '074228306',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'security_role_id' => 4,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert(
            [
                'full_name' => 'Administrador',
                'is_admin' => 1,
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'), // password
                'remember_token' => Str::uuid()->toString(),
            ]
        );
    }
}

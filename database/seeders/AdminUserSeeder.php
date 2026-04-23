<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed an initial admin account into tblusers.
     */
    public function run(): void
    {
        DB::table('tblusers')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@example.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'status'   => 'active',
            ]
        );
    }
}

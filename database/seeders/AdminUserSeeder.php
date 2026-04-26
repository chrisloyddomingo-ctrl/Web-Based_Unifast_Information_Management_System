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
            ['email' => 'admin@unifast.com'],
            [
                'name'     => 'Admin',
                'email'    => 'admin@unifast.com',
                'password' => Hash::make('Admin@1234'),
                'role'     => 'admin',
                'status'   => 'active',
            ]
        );
    }
}

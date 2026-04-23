<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\TblUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin user.
     *
     * @return void
     */
    public function run()
    {
        TblUser::create([
            'name'     => 'Administrator',
            'email'    => 'admin@unifast.com',
            'password' => Hash::make('Admin@1234'),
            'role'     => 'admin',
            'status'   => 'active',
        ]);
    }
}

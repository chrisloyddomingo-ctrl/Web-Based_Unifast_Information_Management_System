<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Ensure the canonical admin account (admin@unifast.com / Admin@1234)
     * exists in tblusers regardless of what test data was seeded previously.
     *
     * Two cases are handled:
     *  1. A stale admin@example.com record exists  → update it in-place.
     *  2. No admin@example.com record exists        → upsert by target email
     *     so the row is created if absent or left
     *     untouched if it was already correct.
     */
    public function up(): void
    {
        $staleEmail  = 'admin@example.com';
        $targetEmail = 'admin@unifast.com';

        $stale = DB::table('tblusers')->where('email', $staleEmail)->first();

        if ($stale) {
            // Update the stale record to the correct credentials.
            DB::table('tblusers')
                ->where('email', $staleEmail)
                ->update([
                    'name'       => 'Admin',
                    'email'      => $targetEmail,
                    'password'   => Hash::make('Admin@1234'),
                    'role'       => 'admin',
                    'status'     => 'active',
                    'updated_at' => now(),
                ]);
        } else {
            // No stale record — insert or update the target admin row.
            DB::table('tblusers')->upsert(
                [
                    'name'       => 'Admin',
                    'email'      => $targetEmail,
                    'password'   => Hash::make('Admin@1234'),
                    'role'       => 'admin',
                    'status'     => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                ['email'],          // unique key used to detect duplicates
                ['name', 'password', 'role', 'status', 'updated_at']
            );
        }
    }

    /**
     * The down() method is intentionally a no-op.
     *
     * Rolling back a credential-fix migration would restore broken
     * credentials, which is never the desired outcome.
     */
    public function down(): void
    {
        // Intentionally left empty.
    }
};

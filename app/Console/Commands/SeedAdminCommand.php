<?php

namespace App\Console\Commands;

use Database\Seeders\AdminUserSeeder;
use Illuminate\Console\Command;

class SeedAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed an admin user account';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        (new AdminUserSeeder())->run();

        $this->info('Admin user seeded successfully.');
    }
}

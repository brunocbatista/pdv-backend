<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\tenant\SystemUserSeeder;
use Database\Seeders\tenant\UserTypeSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (tenant()) {
            $this->call(UserTypeSeeder::class);
            $this->call(SystemUserSeeder::class);

            return;
        }

        $this->call(TenantSeeder::class);
    }
}

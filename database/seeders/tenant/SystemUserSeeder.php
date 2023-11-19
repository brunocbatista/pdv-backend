<?php

namespace Database\Seeders\tenant;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin ' . tenant()->name,
            'email' => 'admin@' . str_replace('_', '', tenant()->id) . '.com',
            'password' => Hash::make('abc123*'),
            'type_id' => UserTypeEnum::ADMINISTRATOR->value,
            'email_verified_at' => now(),
        ]);
    }
}

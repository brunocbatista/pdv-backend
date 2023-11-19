<?php

namespace Database\Seeders;

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
            'name' => 'Admin PDV',
            'email' => 'bruncbatista@gmail.com',
            'password' => Hash::make('abc123*'),
            'type_id' => UserTypeEnum::ADMINISTRATOR->value,
            'email_verified_at' => now(),
        ]);
    }
}

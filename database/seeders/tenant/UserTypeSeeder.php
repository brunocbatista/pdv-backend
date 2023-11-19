<?php

namespace Database\Seeders\tenant;

use App\Enums\UserTypeEnum;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = UserTypeEnum::cases();

        foreach ($userTypes as $type) {
            UserType::create([
                'description' => $type->label(),
                'abilities' => $type->abilities()
            ]);
        }
    }
}

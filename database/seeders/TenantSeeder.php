<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = Tenant::create([
            'id' => 'punta_cana_garaparia',
            'name' => 'Punta Cana Garaparia',
        ]);

        $tenant->domains()->create(['domain' => 'puntacanagarapariagourmet.localhost']);
    }
}

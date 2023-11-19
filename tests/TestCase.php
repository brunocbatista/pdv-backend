<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Tenant;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function tearDown(): void
    {
        config([
            'tenancy.queue_database_deletion' => false,
            'tenancy.delete_database_after_tenant_deletion' => true,
        ]);
        Tenant::all()->each->delete();
        parent::tearDown();
    }
}

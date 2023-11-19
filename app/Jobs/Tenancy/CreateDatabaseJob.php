<?php

namespace App\Jobs\Tenancy;

use Stancl\Tenancy\Jobs\CreateDatabase;
use Stancl\Tenancy\Database\DatabaseManager;

class CreateDatabaseJob extends CreateDatabase
{
    public function handle(DatabaseManager $databaseManager): void
    {
        if (!app()->isProduction()) {
            (new DeleteDatabaseJob($this->tenant))->handle();
        }

        parent::handle($databaseManager);
    }
}

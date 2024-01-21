<?php

namespace App\Actions\Product;

use App\Actions\AbstractAllData;
use App\Models\Product;

class AllProducts extends AbstractAllData
{
    protected function modelName(): string
    {
        return Product::class;
    }
}

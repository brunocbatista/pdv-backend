<?php

namespace App\Actions\Product;

use App\Actions\AbstractGetData;
use App\Models\Product;

class GetProduct extends AbstractGetData
{

    protected function modelName(): string
    {
        return Product::class;
    }
}

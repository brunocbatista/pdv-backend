<?php

namespace App\Actions\Product;

use App\Actions\AbstractCreateNewData;
use App\Models\Product;

class CreateNewProduct extends AbstractCreateNewData
{

    protected function modelName(): string
    {
        return Product::class;
    }
}

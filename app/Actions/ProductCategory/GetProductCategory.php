<?php

namespace App\Actions\ProductCategory;

use App\Actions\AbstractGetData;
use App\Models\ProductCategory;

class GetProductCategory extends AbstractGetData
{

    protected function modelName(): string
    {
        return ProductCategory::class;
    }
}

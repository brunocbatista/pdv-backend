<?php

namespace App\Actions\ProductCategory;

use App\Actions\AbstractCreateNewData;
use App\Models\ProductCategory;

class CreateNewProductCategory extends AbstractCreateNewData
{

    protected function modelName(): string
    {
        return ProductCategory::class;
    }
}

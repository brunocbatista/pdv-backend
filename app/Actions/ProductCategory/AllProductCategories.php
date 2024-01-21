<?php

namespace App\Actions\ProductCategory;

use App\Actions\AbstractAllData;
use App\Models\ProductCategory;

class AllProductCategories extends AbstractAllData
{
    protected function modelName(): string
    {
        return ProductCategory::class;
    }
}

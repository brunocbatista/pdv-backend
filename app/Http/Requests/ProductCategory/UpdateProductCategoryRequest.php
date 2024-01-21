<?php

namespace App\Http\Requests\ProductCategory;

class UpdateProductCategoryRequest extends BaseProductCategoryRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}

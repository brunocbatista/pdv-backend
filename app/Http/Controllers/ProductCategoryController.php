<?php

namespace App\Http\Controllers;

use App\Actions\ProductCategory\AllProductCategories;
use App\Actions\ProductCategory\CreateNewProductCategory;
use App\Actions\ProductCategory\DeleteProductCategory;
use App\Actions\ProductCategory\GetProductCategory;
use App\Actions\ProductCategory\RestoreProductCategory;
use App\Actions\ProductCategory\UpdateProductCategory;
use App\Http\Requests\ProductCategory\StoreProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateProductCategoryRequest;
use Illuminate\Http\JsonResponse;

class ProductCategoryController extends Controller
{
    public function index(AllProductCategories $allProductCategories): JsonResponse
    {
        $productCategories = $allProductCategories->handle();

        return $this->sendJsonOK($productCategories->toArray());
    }

    public function store(StoreProductCategoryRequest $request, CreateNewProductCategory $createNewProductCategory): JsonResponse
    {
        $payload = $request->validated();

        $productCategory = $createNewProductCategory->handle($payload);

        return $this->sendJsonOK($productCategory->toArray());
    }

    public function show(int $id, GetProductCategory $getProductCategory): JsonResponse
    {
        $productCategory = $getProductCategory->handle(
            $id,
            withTrashed: true
        );

        return $this->sendJsonOK($productCategory->toArray());
    }

    public function update(UpdateProductCategoryRequest $request, int $id, GetProductCategory $getProductCategory, UpdateProductCategory $updateProductCategory): JsonResponse
    {
        $payload = $request->validated();

        $productCategory = $getProductCategory->handle($id);
        $updateProductCategory->handle($productCategory, $payload);

        return $this->sendJsonOK($productCategory->toArray());
    }

    public function delete(int $id, GetProductCategory $getProductCategory, DeleteProductCategory $deleteProductCategory): JsonResponse
    {
        $productCategory = $getProductCategory->handle($id);
        $deleteProductCategory->handle($productCategory);

        return $this->sendJsonOK();
    }

    public function restore(int $id, GetProductCategory $getProductCategory, RestoreProductCategory $restoreProductCategory): JsonResponse
    {
        $productCategory = $getProductCategory->handle(
            $id,
            withTrashed: true
        );
        $restoreProductCategory->handle($productCategory);

        return $this->sendJsonOK();
    }
}

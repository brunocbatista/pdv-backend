<?php

namespace App\Http\Controllers;

use App\Actions\Product\AllProducts;
use App\Actions\Product\CreateNewProduct;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\GetProduct;
use App\Actions\Product\RestoreProduct;
use App\Actions\Product\UpdateProduct;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(AllProducts $allProducts): JsonResponse
    {
        $products = $allProducts->handle();

        return $this->sendJsonOK($products->toArray());
    }

    public function store(StoreProductRequest $request, CreateNewProduct $createNewProduct): JsonResponse
    {
        $payload = $request->validated();

        $product = $createNewProduct->handle($payload);

        return $this->sendJsonOK($product->toArray());
    }

    public function show(int $id, GetProduct $getProduct): JsonResponse
    {
        $product = $getProduct->handle(
            $id,
            withTrashed: true
        );

        return $this->sendJsonOK($product->toArray());
    }

    public function update(UpdateProductRequest $request, int $id, GetProduct $getProduct, UpdateProduct $updateProduct): JsonResponse
    {
        $payload = $request->validated();

        $product = $getProduct->handle($id);
        $updateProduct->handle($product, $payload);

        return $this->sendJsonOK($product->toArray());
    }

    public function delete(int $id, GetProduct $getProduct, DeleteProduct $deleteProduct): JsonResponse
    {
        $product = $getProduct->handle($id);
        $deleteProduct->handle($product);

        return $this->sendJsonOK();
    }

    public function restore(int $id, GetProduct $getProduct, RestoreProduct $restoreProduct): JsonResponse
    {
        $product = $getProduct->handle(
            $id,
            withTrashed: true
        );
        $restoreProduct->handle($product);

        return $this->sendJsonOK();
    }
}

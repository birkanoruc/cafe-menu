<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Contracts\Services\ProductServiceInterface;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Venue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function show(Product $product): JsonResponse
    {
        Gate::authorize('view', $product);

        return $this->productService->getProductById($product->id);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        return $this->productService->createProduct($request->validated());
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        Gate::authorize('update', $product);

        return $this->productService->updateProduct($product->id, $request->validated());
    }

    public function destroy(Product $product): JsonResponse
    {
        Gate::authorize('delete', $product);

        return $this->productService->deleteProduct($product->id);
    }
}

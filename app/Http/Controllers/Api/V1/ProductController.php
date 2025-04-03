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
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ImageUploadException;

class ProductController extends Controller
{
    // private ProductServiceInterface $productService;

    // public function __construct(ProductServiceInterface $productService)
    // {
    //     $this->productService = $productService;
    // }

    public function show(Product $product): JsonResponse
    {
        Gate::authorize('view', $product);

        return response()->json(new ProductResource($product->load('categories')), 200);
    }

    public function store(ProductStoreRequest $request): JsonResponse
    {
        $productData = $request->validated();

        if ($request->hasFile('featured_image')) {
            $productData['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        $categoryIds = $productData['category_ids'];

        unset($productData['category_ids']);

        $product = Product::create($productData);

        $product->categories()->sync($categoryIds);

        return response()->json(['message' => 'Ürün başarıyla oluşturuldu!', "product" => new ProductResource($product->load("categories"))], 201);
    }

    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        Gate::authorize('update', $product);

        $productData = $request->validated();

        if ($request->hasFile('featured_image')) {
            $productData['featured_image'] = $this->uploadImage($request->file('featured_image'));

            $product->featured_image && $this->deleteImage($product->featured_image);

            $productData['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        $categoryIds = $productData['category_ids'];

        unset($productData['category_ids']);

        $product->update($productData);

        $product->categories()->sync($categoryIds);

        return response()->json(['message' => 'Ürün başarıyla güncellendi!', "product" => new ProductResource($product->load("categories"))], 200);
    }

    public function destroy(Product $product): JsonResponse
    {
        Gate::authorize('delete', $product);

        $product->featured_image && $this->deleteImage($product->featured_image);

        $product->categories()->sync([]);

        $product->delete();

        return response()->json(['message' => 'Ürün başarıyla silindi!'], 200);
    }

    protected function uploadImage($image): string
    {
        $path = $image->store('featured_images/products', 'public');

        if (!$path) {
            throw new ImageUploadException();
        }

        return Storage::url($path);
    }

    protected function deleteImage(string $imagePath): void
    {
        $path = str_replace('/storage/', '', $imagePath);
        Storage::disk('public')->delete($path);
    }
}

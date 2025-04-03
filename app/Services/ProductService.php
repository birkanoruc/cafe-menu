<?php

namespace App\Services;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\Exceptions\ImageUploadException;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductService implements ProductServiceInterface
{
    // protected ProductRepositoryInterface $productRepository;

    // public function __construct(ProductRepositoryInterface $productRepository)
    // {
    //     $this->productRepository = $productRepository;
    // }

    public function getProductById(int $productId): JsonResponse
    {
        $product = Product::with("categories")->find($productId);

        return response()->json(new ProductResource($product), 200);
    }

    public function createProduct(array $productData): JsonResponse
    {
        if (isset($productData['featured_image'])) {
            $productData['featured_image'] = $this->uploadImage($productData['featured_image']);
        }

        $categoryIds = $productData['category_ids'];

        unset($productData['category_ids']);

        $product = Product::create($productData);

        $product->categories()->sync($categoryIds);

        return response()->json(['message' => 'Ürün başarıyla oluşturuldu!', "product" => new ProductResource($product->load("categories"))], 201);
    }

    public function updateProduct(int $productId, array $productData): JsonResponse
    {
        $product = Product::with("categories")->find($productId);

        if (isset($productData['featured_image'])) {

            $product->featured_image && $this->deleteImage($product->featured_image);

            $productData['featured_image'] = $this->uploadImage($productData['featured_image']);
        }

        $categoryIds = $productData['category_ids'];

        unset($productData['category_ids']);

        $product->update($productData);

        $product->categories()->sync($categoryIds);

        return response()->json(['message' => 'Ürün başarıyla güncellendi!', "product" => new ProductResource($product->load("categories"))], 200);
    }

    public function deleteProduct(int $productId): JsonResponse
    {
        $product = Product::with("categories")->find($productId);

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

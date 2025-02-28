<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProductById(int $productId): Product
    {
        $product = Product::with("categories")->find($productId);

        if (!$product) {
            throw new NotFoundException("Ürün bulunamadı!", 404);
        }

        return $product;
    }

    public function createProduct(array $productData): Product
    {
        return Product::create($productData);
    }

    public function updateProduct(Product $product, array $productData): Product
    {
        $product->updateOrFail($productData);

        return $product;
    }

    public function deleteProduct(Product $product): void
    {
        $product->deleteOrFail();
    }

    public function syncCategories(Product $product, array $categoryIds): void
    {
        $product->categories()->sync($categoryIds);
    }
}

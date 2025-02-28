<?php

namespace App\Contracts\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Kimliği belirtilen ürünü ilişkileri ile getiren depo metodunu tanımlar.
     * @param int $productId
     * @return Product
     */
    public function getProductById(int $productId): Product;

    /**
     * Ürünü oluşturan depo metodunu tanımlar.
     * @param array $productData
     * @return Product
     */
    public function createProduct(array $productData): Product;

    /**
     * Kimliği belirtilen ürünü güncelleyen depo metodunu tanımlar.
     * @param Product $product
     * @param array $productData
     * @return Product
     */
    public function updateProduct(Product $product, array $productData): Product;

    /**
     * Kimliği belirtilen ürünü silen depo metodunu tanımlar.
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product): void;

    /**
     * Kimliği belirtilen ürünün kategorilerini senkronize eden depo metodunu tanımlar.
     * @param Product $product
     * @param array $categoryIds
     * @return void
     */
    public function syncCategories(Product $product, array $categoryIds): void;
}

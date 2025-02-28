<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface ProductServiceInterface
{
    /**
     * Kimliği belirtilen ürünü getiren metodu tanımlar.
     * @param int $productId
     * @return JsonResponse
     */
    public function getProductById(int $productId): JsonResponse;

    /**
     * Ürün ekleyen metodu tanımlar.
     * @param array $productData
     * @return JsonResponse
     */
    public function createProduct(array $productData): JsonResponse;

    /**
     * Kimliği belirtilen ürünü güncelleyen metodu tanımlar.
     * @param int $productId
     * @param array $productData
     * @return JsonResponse
     */
    public function updateProduct(int $productId, array $productData): JsonResponse;

    /**
     * Kimliği belirtilen ürünü silen metodu tanımlar.
     * @param int $productId
     * @return JsonResponse
     */
    public function deleteProduct(int $productId): JsonResponse;
}

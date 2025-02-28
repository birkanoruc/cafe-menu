<?php

namespace App\Contracts\Services;

use Illuminate\Http\JsonResponse;

interface CategoryServiceInterface
{
    /**
     * Kimliği belirtilen kategoriyi getiren metodu tanımlar.
     * @param int $categoryId
     * @return JsonResponse
     */
    public function getCategoryById(int $categoryId): JsonResponse;

    /**
     * Kategori oluşturan metodu tanımlar.
     * @param array $categoryData
     * @return JsonResponse
     */
    public function createCategory(array $categoryData): JsonResponse;

    /**
     * Kimliği belirtilen kategoriyi güncelleyen metodu tanımlar.
     * @param int $categoryId
     * @param array $categoryData
     * @return JsonResponse
     */
    public function updateCategory(int $categoryId, array $categoryData): JsonResponse;

    /**
     * Kimliği belirtilen kategoriyi silen metodu tanımlar.
     * @param int $categoryId
     * @return JsonResponse
     */
    public function deleteCategory(int $categoryId): JsonResponse;
}

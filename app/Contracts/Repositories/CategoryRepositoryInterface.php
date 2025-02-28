<?php

namespace App\Contracts\Repositories;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    /**
     * Kimliği belirtilen kategoriyi ilişkileri ile getiren depo metodunu tanımlar.
     * @param int $categoryId
     * @return Category
     */
    public function getCategoryById(int $categoryId): Category;

    /**
     * Kategoriyi oluşturan depo metodunu tanımlar.
     * @param array $categoryData
     * @return Category
     */
    public function createCategory(array $categoryData): Category;

    /**
     * Kimliği belirtilen kategoriyi güncelleyen depo metodunu tanımlar.
     * @param Category $category
     * @param array $categoryData
     * @return Category
     */
    public function updateCategory(Category $category, array $categoryData): Category;

    /**
     * Kimliği belirtilen kategoriyi silen depo metodunu tanımlar.
     * @param Category $category
     * @return void
     */
    public function deleteCategory(Category $category): void;
}

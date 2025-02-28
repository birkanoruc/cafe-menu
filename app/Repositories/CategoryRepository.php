<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getCategoryById(int $categoryId): Category
    {
        $category = Category::with("products")->find($categoryId);

        if (!$category) {
            throw new NotFoundException("Kategori bulunamadı!", 404);
        }

        return $category;
    }

    public function createCategory(array $categoryData): Category
    {
        return Category::create($categoryData);
    }

    public function updateCategory(Category $category, array $categoryData): Category
    {
        $category->updateOrFail($categoryData);

        return $category;
    }

    public function deleteCategory(Category $category): void
    {
        $category->deleteOrFail();
    }
}

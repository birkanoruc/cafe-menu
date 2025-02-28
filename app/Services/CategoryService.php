<?php

namespace App\Services;

use App\Contracts\Services\CategoryServiceInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ImageUploadException;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class CategoryService implements CategoryServiceInterface
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoryById(int $categoryId): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);

        return response()->json(new CategoryResource($category), 200);
    }

    public function createCategory(array $categoryData): JsonResponse
    {
        if (isset($categoryData['featured_image'])) {
            $categoryData['featured_image'] = $this->uploadImage($categoryData['featured_image']);
        }

        $category = $this->categoryRepository->createCategory($categoryData);

        return response()->json(['message' => 'Kategori başarıyla oluşturuldu!', "category" => CategoryResource::make($category)], 201);
    }

    public function updateCategory(int $categoryId, array $categoryData): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);

        if (isset($categoryData['featured_image'])) {

            $category->featured_image && $this->deleteImage($category->featured_image);

            $categoryData['featured_image'] = $this->uploadImage($categoryData['featured_image']);
        }

        $category = $this->categoryRepository->updateCategory($category, $categoryData);

        return response()->json(['message' => 'Kategori başarıyla güncellendi!', "category" => CategoryResource::make($category)], 200);
    }

    public function deleteCategory(int $categoryId): JsonResponse
    {
        $category = $this->categoryRepository->getCategoryById($categoryId);

        $category->featured_image && $this->deleteImage($category->featured_image);

        $this->categoryRepository->deleteCategory($category);

        return response()->json(['message' => 'Kategori başarıyla silindi!'], 200);
    }

    protected function uploadImage($image): string
    {
        $path = $image->store('featured_images/categories', 'public');

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

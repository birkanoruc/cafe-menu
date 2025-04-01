<?php

namespace App\Services;

use App\Contracts\Services\CategoryServiceInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Exceptions\ImageUploadException;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\NotFoundException;
use App\Models\Category;

class CategoryService implements CategoryServiceInterface
{
    public function getCategoryById(int $categoryId): JsonResponse
    {
        $category = Category::with("products")->find($categoryId);

        if (!$category) {
            throw new NotFoundException("Kategori bulunamadı!", 404);
        }

        return response()->json(new CategoryResource($category), 200);
    }

    public function createCategory(array $categoryData): JsonResponse
    {
        if (isset($categoryData['featured_image'])) {
            $categoryData['featured_image'] = $this->uploadImage($categoryData['featured_image']);
        }

        $category = Category::create($categoryData);

        return response()->json(['message' => 'Kategori başarıyla oluşturuldu!', "category" => CategoryResource::make($category)], 201);
    }

    public function updateCategory(int $categoryId, array $categoryData): JsonResponse
    {
        $category = Category::with("products")->find($categoryId);

        if (isset($categoryData['featured_image'])) {

            $category->featured_image && $this->deleteImage($category->featured_image);

            $categoryData['featured_image'] = $this->uploadImage($categoryData['featured_image']);
        }

        $category = $category->updateOrFail($categoryData);

        return response()->json(['message' => 'Kategori başarıyla güncellendi!', "category" => CategoryResource::make($category)], 200);
    }

    public function deleteCategory(int $categoryId): JsonResponse
    {
        $category = Category::with("products")->find($categoryId);

        $category->featured_image && $this->deleteImage($category->featured_image);

        $category->deleteOrFail();

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

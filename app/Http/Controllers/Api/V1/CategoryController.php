<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Contracts\Services\CategoryServiceInterface;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CategoryResource;
use App\Exceptions\ImageUploadException;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function show(Category $category): JsonResponse
    {
        Gate::authorize('view', $category);

        $category->load(['products']);

        return response()->json(new CategoryResource($category), 200);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $categoryData = $request->validated();

        if ($request->hasFile('featured_image')) {
            $categoryData['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        $category = Category::create($categoryData);

        return response()->json(['message' => 'Kategori başarıyla oluşturuldu!', "category" => CategoryResource::make($category)], 201);
    }

    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        Gate::authorize('update', $category);

        $categoryData = $request->validated();

        if ($request->hasFile('featured_image')) {
            $categoryData['featured_image'] = $this->uploadImage($request->file('featured_image'));

            $category->featured_image && $this->deleteImage($category->featured_image);

            $categoryData['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        $category->update($categoryData);

        return response()->json(['message' => 'Kategori başarıyla güncellendi!', "category" => CategoryResource::make($category->load('products'))], 200);
    }

    public function destroy(Category $category): JsonResponse
    {
        Gate::authorize('delete', $category);

        $category->featured_image && $this->deleteImage($category->featured_image);

        $category->delete();

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

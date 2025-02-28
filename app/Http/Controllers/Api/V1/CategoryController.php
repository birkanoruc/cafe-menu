<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Contracts\Services\CategoryServiceInterface;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function show(Category $category): JsonResponse
    {
        Gate::authorize('view', $category);

        return $this->categoryService->getCategoryById($category->id);
    }

    public function store(CategoryStoreRequest $request): JsonResponse
    {
        return $this->categoryService->createCategory($request->validated());
    }

    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        Gate::authorize('update', $category);

        return $this->categoryService->updateCategory($category->id,  $request->validated());
    }

    public function destroy(Category $category): JsonResponse
    {
        Gate::authorize('delete', $category);

        return $this->categoryService->deleteCategory($category->id);
    }
}

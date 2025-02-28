<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Models\Venue;

class CategoryPolicy
{
    public function view(User $user, Category $category): bool
    {
        return $user->id === $category->venue->user_id;
    }

    public function update(User $user, Category $category): bool
    {
        return $user->id === $category->venue->user_id;
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->id === $category->venue->user_id;
    }
}

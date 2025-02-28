<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;

class VenuePolicy
{
    public function view(User $user, Venue $venue): bool
    {
        return $user->id === $venue->user_id;
    }

    public function update(User $user, Venue $venue): bool
    {
        return $user->id === $venue->user_id;
    }

    public function delete(User $user, Venue $venue): bool
    {
        return $user->id === $venue->user_id;
    }
}

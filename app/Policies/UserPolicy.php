<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user):bool
    {
        return in_array($user->privilege_id,[1,2]);

    }

    public function update(User $user): bool
    {
        return in_array($user->privilege_id,[1,2]);
    }
    public function updateAdmin(User $user): bool
    {
        return in_array($user->privilege_id, [1]);
    }
}

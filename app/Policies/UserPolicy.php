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
    public function view(User $authUser,User $targetUser):bool
    {
        return in_array($authUser->privilege_id,[1,2]) || $authUser->id === $targetUser->id;

    }



    public function update(User $user): bool
    {
        return in_array($user->privilege_id,[1,2]);
    }
    public function updateAdmin(User $user): bool
    {
        return in_array($user->privilege_id, [1]);
    }
    public function delete(User $user, User $currentUser): bool
    {
        return in_array($user->privilege_id,[1,2])|| $currentUser->id === $user->id;
    }
}

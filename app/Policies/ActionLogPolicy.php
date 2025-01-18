<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ActionLog;
use App\Models\User;

class ActionLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewLogs(User $user)
    {
        return in_array($user->privilege_id,[1,2]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ActionLog $actionLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ActionLog $actionLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ActionLog $actionLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ActionLog $actionLog): bool
    {
        return false;
    }
}

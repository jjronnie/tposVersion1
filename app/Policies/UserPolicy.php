<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User as UserModel; // Renamed to avoid confusion
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(UserModel $user, UserModel $modelToView): bool
    {
        // The authenticated user's business_id must match the business_id of the user they are trying to view.
        return $user->business_id === $modelToView->business_id;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserModel $user): bool
    {
        // For 'viewAny', this can be as simple as checking if the user is authenticated.
        // The scope will handle the rest.
        return true;
    }
}
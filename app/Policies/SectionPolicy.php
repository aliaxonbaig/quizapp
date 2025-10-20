<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Section;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_section');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Section $section): bool
    {
        return $user->can('view_section');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_section');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Section $section): bool
    {
        return $user->can('update_section');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Section $section): bool
    {
        return $user->can('delete_section');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_section');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Section $section): bool
    {
        return $user->can('force_delete_section');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_section');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Section $section): bool
    {
        return $user->can('{{ Restore }}');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('{{ RestoreAny }}');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Section $section): bool
    {
        return $user->can('{{ Replicate }}');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('{{ Reorder }}');
    }
}

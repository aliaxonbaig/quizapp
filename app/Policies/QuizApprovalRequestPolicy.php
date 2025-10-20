<?php

namespace App\Policies;

use App\Models\User;
use App\Models\QuizApprovalRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizApprovalRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_quiz::approval::request');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, QuizApprovalRequest $quizApprovalRequest): bool
    {
        return $user->can('view_quiz::approval::request');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_quiz::approval::request');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, QuizApprovalRequest $quizApprovalRequest): bool
    {
        return $user->can('update_quiz::approval::request');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, QuizApprovalRequest $quizApprovalRequest): bool
    {
        return $user->can('delete_quiz::approval::request');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_quiz::approval::request');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, QuizApprovalRequest $quizApprovalRequest): bool
    {
        return $user->can('force_delete_quiz::approval::request');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_quiz::approval::request');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, QuizApprovalRequest $quizApprovalRequest): bool
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
    public function replicate(User $user, QuizApprovalRequest $quizApprovalRequest): bool
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

<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BumnagProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class BumnagProfilePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BumnagProfile');
    }

    public function view(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('View:BumnagProfile');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BumnagProfile');
    }

    public function update(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('Update:BumnagProfile');
    }

    public function delete(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('Delete:BumnagProfile');
    }

    public function restore(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('Restore:BumnagProfile');
    }

    public function forceDelete(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('ForceDelete:BumnagProfile');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BumnagProfile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BumnagProfile');
    }

    public function replicate(AuthUser $authUser, BumnagProfile $bumnagProfile): bool
    {
        return $authUser->can('Replicate:BumnagProfile');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BumnagProfile');
    }

}
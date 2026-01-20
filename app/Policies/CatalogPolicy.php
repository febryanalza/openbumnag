<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Catalog;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.view-any');
    }

    public function view(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.view');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.create');
    }

    public function update(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.update');
    }

    public function delete(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function restore(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function forceDelete(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.delete');
    }

    public function replicate(AuthUser $authUser, Catalog $catalog): bool
    {
        return $authUser->can('catalog.create');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('catalog.update');
    }
}

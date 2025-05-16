<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DeliveryEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryEventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super_admin', 'manager', 'user']);
    }

    public function view(User $user, DeliveryEvent $deliveryEvent): bool
    {
        if($user->hasRole('super_admin'))
        {
            return true;
        } else{
            return $user->id === $deliveryEvent->users_id;
        }
        // return $user->hasRole(['super_admin', 'manager', 'user']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'manager', 'user']);
    }

    public function update(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['super_admin', 'manager', 'user']);
    }

    public function delete(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['super_admin', 'user']);
    }

    public function restore(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['super_admin', 'user']);
    }

    public function forceDelete(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['super_admin', 'user']);
    }
}

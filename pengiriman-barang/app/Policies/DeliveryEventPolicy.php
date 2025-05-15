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
        return $user->hasRole(['admin', 'manager', 'user']);
    }

    public function view(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['admin', 'manager', 'user']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager', 'user']);
    }

    public function update(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['admin', 'manager', 'user']);
    }

    public function delete(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['admin', 'user']);
    }

    public function restore(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['admin', 'user']);
    }

    public function forceDelete(User $user, DeliveryEvent $deliveryEvent): bool
    {
        return $user->hasRole(['admin', 'user']);
    }
}

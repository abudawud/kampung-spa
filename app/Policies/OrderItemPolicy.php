<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\OrderItem;
use App\Models\User;

class OrderItemPolicy
{
    use HandlesAuthorization;
    const POLICY_NAME = "trans.order.item";

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can(self::POLICY_NAME . ".viewAny");
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  OrderItem  $model
     * @return Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OrderItem $model)
    {
        return $user->can(self::POLICY_NAME . ".view");
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can(self::POLICY_NAME . ".create");
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  OrderItem  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OrderItem $model)
    {
        return $user->can(self::POLICY_NAME . ".update");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  OrderItem  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OrderItem $model)
    {
        return $user->can(self::POLICY_NAME . ".delete");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  OrderItem  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, OrderItem $model)
    {
        return $user->can(self::POLICY_NAME . ".restore");
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \User  $user
     * @param  \OrderItem  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, OrderItem $model)
    {
        return $user->can(self::POLICY_NAME . ".forceDelete");
    }
}

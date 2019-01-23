<?php

namespace App\Policies;

use App\User;
use App\Order;

class OrderPolicy
{

    public function before($user, $ability)
    {
        if ($user->admin == 1) {
            return true;
        }
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }
}
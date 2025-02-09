<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('users.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('orders.{orderId}', function (User $user, $orderId) {
    return $user->id === Order::findOrNew($orderId)->user_id;
});

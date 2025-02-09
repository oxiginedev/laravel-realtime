<?php

use App\Events\OrderDelivered;
use App\Events\OrderDispatched;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast', function () {
    $order = Order::find(1);
    sleep(2);

    broadcast(new OrderDispatched($order));

    sleep(5);

    broadcast(new OrderDelivered($order));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/orders/{order}', function (Order $order) {
        return view('orders.show', [
            'order' => $order,
        ]);
    })->name('orders.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

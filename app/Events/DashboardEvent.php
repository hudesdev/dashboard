<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

abstract class DashboardEvent implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new PrivateChannel('dashboard');
    }

    public static function dispatch(...$args)
    {
        event(new static(...$args));
    }
}

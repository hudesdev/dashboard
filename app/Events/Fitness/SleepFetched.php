<?php

namespace App\Events\Fitness;

use App\Events\DashboardEvent;

class SleepFetched extends DashboardEvent
{
    /** @var int */
    public $duration;

    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }
}

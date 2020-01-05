<?php

namespace App\Events\Fitness;

use App\Events\DashboardEvent;

class StepsFetched extends DashboardEvent
{
    /** @var int */
    public $steps;

    public function __construct(int $steps)
    {
        $this->steps = $steps;
    }
}

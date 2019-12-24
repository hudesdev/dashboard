<?php

namespace App\Events\Uptime;

use App\Events\DashboardEvent;

class UptimeCheckRecovered extends DashboardEvent
{
    /** @var array */
    public $site;

    public function __construct(array $site)
    {
        $this->site = $site;
    }
}

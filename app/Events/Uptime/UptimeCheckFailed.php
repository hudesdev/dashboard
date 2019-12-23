<?php

namespace App\Events\Uptime;

use App\Events\DashboardEvent;

class UptimeCheckFailed extends DashboardEvent
{
    /** @var string */
    public $url;

    public function __construct(string $siteUrl)
    {
        $this->url = $siteUrl;
    }
}

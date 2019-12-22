<?php

namespace App\Events\Statistics;

use App\Events\DashboardEvent;

class FathomTotalsFetched extends DashboardEvent
{
    /** @var int */
    public $uniqueVisitors;

    /** @var int */
    public $pageviews;

    /** @var int */
    public $avgTime;

    /** @var int */
    public $bounceRate;

    /** @var int */
    public $currentVisitors;

    public function __construct(array $totals)
    {
        foreach ($totals as $statisticName => $total) {
            $this->$statisticName = $total;
        }
    }
}

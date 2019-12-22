<?php

namespace App\Events\Statistics;

use App\Events\DashboardEvent;

class MRRFetched extends DashboardEvent
{
    /** @var array */
    public $mrr;

    public function __construct(array $mrr)
    {
        $this->mrr = $mrr;
    }
}

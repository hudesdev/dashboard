<?php

namespace App\Events\Spotify;

use App\Events\DashboardEvent;

class NewToken extends DashboardEvent
{
    /** @var string */
    public $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\Uptime\UptimeCheckFailed;
use App\Events\Uptime\UptimeCheckRecovered;
use Illuminate\Http\Request;

class PingPingController
{
    public function __invoke(Request $request)
    {
        abort_unless($request->json('check.name') == 'uptime', 200, 'ok');

        if ($request->json('check.status') != 'ok') {
            UptimeCheckFailed::dispatch($request->json('monitor.url'));
        } else {
            UptimeCheckRecovered::dispatch($request->json('monitor.url'));
        }

        echo 'ok';
    }
}

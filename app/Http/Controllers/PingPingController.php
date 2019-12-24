<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Uptime\UptimeCheckFailed;
use App\Events\Uptime\UptimeCheckRecovered;

class PingPingController
{
    public function __invoke(Request $request)
    {
        abort_unless($request->json('0.check.name') == 'uptime', 200, 'ok');

        if ($request->json('0.check.status') != 'ok') {
            UptimeCheckFailed::dispatch($request->json('0.monitor'), $request->json('0.check.last_check_at'));
        } else {
            UptimeCheckRecovered::dispatch($request->json('0.monitor'));
        }

        echo 'ok';
    }
}

<?php

namespace App\Services\Fathom;

use Zttp\Zttp;
use GuzzleHttp\Client;

class FathomApi
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchTotalsForSites(array $siteIds)
    {
        $data = collect($siteIds)->map(function($siteId) {
            return $this->fetchTotalsForSite($siteId);
        });

        return [
            'pageviews' => $data->sum('pageviews'),
            'uniqueVisitors' => $data->sum('uniqueVisitors'),
            'avgTime' => $data->avg('avgTime'),
            'bounceRate' => $data->avg('bounceRate'),
            'currentVisitors' => $data->sum('currentVisitors'),
        ];

    }

    public function fetchTotalsForSite(int $siteId): array
    {
        $data = Zttp::get("https://app.usefathom.com/sites/$siteId/totals?from=".urlencode(today()->toDateTimeString()).'&to='.urlencode(today()->addDay()->toDateTimeString()).'&tz=Europe/Madrid')->json();

        return with($data['current'], function ($totals) use ($siteId) {
            return [
                'pageviews' => $totals['pageviews'],
                'uniqueVisitors' => $totals['visits'],
                'avgTime' => $totals['avg_duration'],
                'bounceRate' => $totals['bounce_rate'],
                'currentVisitors' => $this->getCurrentVisitorsforSite($siteId),
            ];
        });
    }

    public function getCurrentVisitorsforSite(int $siteId): string
    {
        return Zttp::get("https://app.usefathom.com/sites/$siteId/current_visitors?from=".urlencode(today()->toDateTimeString()).'&to='.urlencode(today()->addDay()->toDateTimeString()).'&tz=Europe/Madrid')->json()['total'];
    }
}

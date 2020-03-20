<?php

namespace App\Services\MRR;

use Zttp\Zttp;

class MRR
{
    public function calculate() : array
    {
        return [
            'sources' => [
                'sitesauce' => $sitesauce = $this->getSitesauceMRR(),
                'patreon' => $patreon = $this->getPatreonMRR(),
                'github' => $github = $this->getGitHubMRR(),
            ],
            'total' => $sitesauce + $patreon + $github,
        ];
    }

    public function getSitesauceMRR()
    {
       return Zttp::get('https://sitesauce-revenue.now.sh/api')->json()['mrr'];
    }

    public function getPatreonMRR()
    {
        return Zttp::get('https://www.patreon.com/api/campaigns/1538972')->json()['data']['attributes']['pledge_sum'] / 100;
    }

    public function getGitHubMRR()
    {
        return collect(Zttp::withHeaders(['Authorization' => 'Bearer '.config('services.github.token')])->post('https://api.github.com/graphql', ['query' => '{ viewer { sponsorsListing { tiers(first: 100) { nodes { adminInfo { sponsorships(first: 100, includePrivate: true) { nodes { tier { monthlyPriceInCents } } } } } } } } }'])->json())->flatten()->sum();
    }
}

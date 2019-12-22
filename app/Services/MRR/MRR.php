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
            ],
            'total' => $sitesauce + $patreon,
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
}

<?php

namespace App\Console\Components\Statistics;

use App\Events\Statistics\MRRFetched;
use Zttp\Zttp;
use App\Services\MRR\MRR;
use Illuminate\Console\Command;

class FetchMRR extends Command
{
    protected $signature = 'dashboard:fetch-mrr';

    protected $description = 'Fetch MRR';

    public function handle(MRR $mrr)
    {
        $this->info('Fetching MRR...');

        event(new MRRFetched($mrr->calculate()));

        $this->info('All done!');
    }
}

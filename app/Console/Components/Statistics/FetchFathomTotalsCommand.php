<?php

namespace App\Console\Components\Statistics;

use Illuminate\Console\Command;
use App\Services\Fathom\FathomApi;
use App\Events\Statistics\FathomTotalsFetched;

class FetchFathomTotalsCommand extends Command
{
    protected $signature = 'dashboard:fetch-fathom-totals';

    protected $description = 'Fetch Fathom totals';

    protected $sites = [
        310, 311, 1025,
    ];

    public function handle(FathomApi $fathom)
    {
        $this->info('Fetching Fathom totals');

        FathomTotalsFetched::dispatch(
            $fathom->fetchTotalsForSites($this->sites)
        );

        $this->info('All done!');
    }
}

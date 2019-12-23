<?php

namespace App\Console\Components\Dashboard;

use Illuminate\Console\Command;
use App\Events\Dashboard\Refresh;

class RefreshDashboardCommand extends Command
{
    protected $signature = 'dashboard:refresh';

    protected $description = 'Refresh the dashboard page';

    public function handle()
    {
        $this->info('Refresing dashboard...');

        Refresh::dispatch();

        $this->info('All done!');
    }
}

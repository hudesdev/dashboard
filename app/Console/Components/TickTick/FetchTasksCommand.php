<?php

namespace App\Console\Components\TickTick;

use Illuminate\Console\Command;
use App\Services\TickTick\TaskApi;
use App\Events\TickTick\TasksFetched;

class FetchTasksCommand extends Command
{
    protected $signature = 'dashboard:fetch-tasks';

    protected $description = 'Fetch tasks from TickTick';

    public function handle()
    {
        $this->info('Fetching tasks from TickTick...');

        TasksFetched::dispatch(
            (new TaskApi)->all()
        );

        $this->info('All done!');
    }
}

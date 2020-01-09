<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Components\Statistics\FetchMRR;
use App\Console\Components\TickTick\FetchTasksCommand;
use App\Console\Components\Google\FetchSleepDataCommand;
use App\Console\Components\Google\FetchStepCountCommand;
use App\Console\Components\Dashboard\SendHeartbeatCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Components\Google\RefreshGoogleTokenCommand;
use App\Console\Components\Spotify\RefreshSpotifyTokenCommand;
use App\Console\Components\Calendar\FetchCalendarEventsCommand;
use App\Console\Components\Statistics\FetchFathomTotalsCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(SendHeartbeatCommand::class)->everyMinute();
        $schedule->command(FetchCalendarEventsCommand::class)->everyMinute();
        $schedule->command(FetchTasksCommand::class)->everyMinute();
        $schedule->command(FetchFathomTotalsCommand::class)->everyMinute();
        $schedule->command(FetchStepCountCommand::class)->everyMinute();
        $schedule->command(FetchSleepDataCommand::class)->everyMinute();
        $schedule->command(FetchMRR::class)->everyMinute();
        $schedule->command(RefreshSpotifyTokenCommand::class)->everyThirtyMinutes();
        $schedule->command(RefreshGoogleTokenCommand::class)->everyThirtyMinutes();
        $schedule->command('websockets:clean')->daily();
    }

    public function commands()
    {
        $commandDirectories = glob(app_path('Console/Components/*'), GLOB_ONLYDIR);
        $commandDirectories[] = app_path('Console');

        collect($commandDirectories)->each(function (string $commandDirectory) {
            $this->load($commandDirectory);
        });
    }
}

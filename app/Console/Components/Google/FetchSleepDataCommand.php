<?php

namespace App\Console\Components\Google;

use Illuminate\Console\Command;
use App\Events\Fitness\SleepFetched;
use Carbon\Carbon;
use Google_Service_Fitness_Session as Session;

class FetchSleepDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-sleep-data';

    protected $description = 'Fetch sleep data from Google Fit';

    public function handle()
    {
        $this->info('Fetching sleep data...');

        $client = app(\Google_Client::class);

        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/google/credentials.json')), true)['access_token']);

        $client = new \Google_Service_Fitness($client);

        $response = $client->users_sessions->listUsersSessions('me', [
            // 'startTime' => today()->addHours(-12),
            // 'endTime' => today()->tomorrow()->addHours(-12),
        ]);

        $duration = collect($response->getSession())->filter(function (Session $session) {
            return $session->getActivityType() === 72;
        })->filter(function (Session $session) {
            return Carbon::parse($session->getEndTimeMillis() / 1000)->isToday();
        })->map(function(Session $session) {
            return ($session->getEndTimeMillis() - $session->getStartTimeMillis()) / 1000;
        })->first() ?? 0;

        SleepFetched::dispatch($duration);

        $this->info('All done!');
    }
}

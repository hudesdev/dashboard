<?php

namespace App\Console\Components\Google;

use Illuminate\Console\Command;
use App\Events\Fitness\StepsFetched;

class FetchStepCountCommand extends Command
{
    protected $signature = 'dashboard:fetch-step-count';

    protected $description = 'Fetch step count from Google Fit';

    public function handle()
    {
        $this->info('Fetching step count...');

        $client = app(\Google_Client::class);

        $client->setAccessToken(json_decode(file_get_contents(storage_path('app/google/credentials.json')), true)['access_token']);

        $client = new \Google_Service_Fitness($client);

        $request = new \Google_Service_Fitness_AggregateRequest;

        $request->setAggregateBy([new \Google_Service_Fitness_AggregateBy([
            'dataTypeName' => 'com.google.step_count.delta',
            'dataSourceId' => 'derived:com.google.step_count.delta:com.google.android.gms:estimated_steps',
        ])]);

        $request->setBucketByTime(new \Google_Service_Fitness_BucketByTime([
            'durationMillis' => 86400000
        ]));

        $request->setStartTimeMillis(today()->timestamp * 1000);
        $request->setEndTimeMillis(today()->addDay()->timestamp * 1000);

        $response = $client->users_dataset->aggregate('me', $request);

        StepsFetched::dispatch($response->getBucket()[0]->getDataset()[0]->getPoint()[0]->getValue()[0]->getIntVal());

        $this->info('All done!');
    }
}

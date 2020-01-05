<?php

namespace App\Console\Components\Google;

use Illuminate\Console\Command;
use Zttp\Zttp;

class RefreshGoogleTokenCommand extends Command
{
    protected $signature = 'dashboard:refresh-google-token';

    protected $description = 'Refresh the Google token';

    public function handle()
    {
        $this->info('Refreshing the token');

        $token = json_decode(file_get_contents(storage_path('app/google/credentials.json')), true)['refresh_token'];

        $response = Zttp::asFormParams()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            'client_id' => config('services.google.id'),
            'client_secret' => config('services.google.secret'),
        ])->json();

        file_put_contents(storage_path('app/google/credentials.json'),  json_encode(array_merge($response, ['refresh_token' => $token])));

        $this->info('All done!');
    }
}

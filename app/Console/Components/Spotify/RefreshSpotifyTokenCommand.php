<?php

namespace App\Console\Components\Spotify;

use App\Events\Spotify\NewToken;
use Illuminate\Console\Command;
use Spatie\NowPlaying\NowPlaying;
use App\Events\TeamMember\PlayingTrack;
use App\Events\TeamMember\PlayingNothing;
use Zttp\Zttp;

class RefreshSpotifyTokenCommand extends Command
{
    protected $signature = 'dashboard:refresh-spotify-token';

    protected $description = 'Refresh the spotify token';

    public function handle()
    {
        $this->info('Refreshing the token');

        $token = json_decode(file_get_contents(storage_path('app/spotify/credentials.json')), true)['refresh_token'];

        $response = Zttp::asFormParams()->withHeaders(['Authorization' => 'Basic '.base64_encode(config('services.spotify.id').':'.config('services.spotify.secret'))])->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token
        ])->json();

        file_put_contents(storage_path('app/spotify/credentials.json'),  json_encode(array_merge($response, ['refresh_token' => $token])));

        NewToken::dispatch($response['access_token']);

        $this->info('All done!');
    }
}

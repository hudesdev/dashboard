<?php

namespace App\Http\Controllers;

use App\Services\TweetHistory\TweetHistory;

class DashboardController
{
    public function __invoke()
    {
        $spotifyToken = json_decode(file_get_contents(storage_path('app/spotify/credentials.json')), true)['access_token'];

        return view('dashboard')->with([
            'pusherKey' => config('broadcasting.connections.pusher.key'),
            'environment' => app()->environment(),
            'initialTweets' => TweetHistory::all(),
            'openWeatherMapKey' => config('services.open_weather_map.key'),
            'openWeatherLat' => config('services.open_weather_map.latitude'),
            'openWeatherLon' => config('services.open_weather_map.longitude'),
            'spotifyToken' => $spotifyToken,
        ]);
    }
}

@extends('layouts/master')

@section('content')

@javascript(compact('pusherKey', 'environment', 'openWeatherMapKey', 'openWeatherLat', 'openWeatherLon', 'spotifyToken'))
<div id="dashboard">
    <dashboard class="font-sans">
        <twitter :initial-tweets="{{ json_encode($initialTweets) }}" position="a1:a24"></twitter>
        <time-weather position="b1:b8" date-format="ddd DD MMM" time-format="hh:mm A" time-zone="Europe/Madrid" weather-city="Oviedo" time-format="h:mm:ss a"></time-weather>
        <fitness position="c1:c8"></fitness>
        <internet-connection position="b1:b8"></internet-connection>
        <task-list position="b9:c16"></task-list>
        <music position="b17:d24"></music>
        <mrr position="d1:d8"></mrr>
        <statistics position="d9:d16"></statistics>
        <uptime position="a1:a24"></uptime>
        <calendar position="e1:e24"></calendar>
    </dashboard>
</div>

@endsection

import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import Dashboard from './components/Dashboard';
import Calendar from './components/Calendar';
import Statistics from './components/Statistics';
import InternetConnection from './components/InternetConnection';
import TaskList from './components/TaskList';
import MRR from './components/MRR';
import TimeWeather from './components/TimeWeather';
import Twitter from './components/Twitter';
import Uptime from './components/Uptime';
import TileTimer from './components/TileTimer';
import Music from './components/Music';

new Vue({
    el: '#dashboard',

    components: {
        Dashboard,
        Calendar,
        Statistics,
        InternetConnection,
        TaskList,
        TimeWeather,
        Twitter,
        Uptime,
        Music,
        TileTimer,
        mrr: MRR,
    },

    created() {
        this.echo = new Echo({
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            disableStats: true,
        });
    },
});

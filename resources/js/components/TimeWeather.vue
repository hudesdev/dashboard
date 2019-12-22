<template>
    <tile :position="position" no-fade>
        <div class="grid gap-2 justify-items-center h-full" style="grid-template-rows: auto 1fr auto;">
            <div class="markup">
                <h1>{{ date }}</h1>
            </div>
            <div class="align-self-center font-bold text-4xl tracking-wide leading-none">{{ time }}</div>
            <div class="uppercase">
                <div class="grid gap-4 items-center" style="grid-template-columns: repeat(3, auto);">
                    <span> {{ weather.temperature }}°</span>
                    <span v-for="(icon, index) in weather.icons" class="text-2xl" v-html="icon" :key="index"></span>
                </div>
                <div class="hidden">{{ weatherCity }}</div>
            </div>
        </div>
    </tile>
</template>

<script>
import { emoji } from '../helpers';
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import moment from 'moment-timezone';
import weather from '../services/weather/Weather';

export default {
    components: {
        Tile,
    },

    mixins: [echo],

    props: {
        weatherCity: {
            type: String,
        },
        dateFormat: {
            type: String,
            default: 'DD-MM-YYYY',
        },
        timeFormat: {
            type: String,
            default: 'HH:mm',
        },
        timeZone: {
            type: String,
        },
        position: {
            type: String,
        },
    },

    data() {
        return {
            date: '',
            time: '',
            weather: {
                temperature: '',
                icon: 0,
            },
        };
    },

    created() {
        this.refreshTime();
        setInterval(this.refreshTime, 1000);

        this.fetchWeather();
        setInterval(this.fetchWeather, 60000);
    },

    methods: {
        emoji,

        refreshTime() {
            this.date = moment()
                .tz(this.timeZone)
                .format(this.dateFormat);
            this.time = moment()
                .tz(this.timeZone)
                .format(this.timeFormat);
        },

        getEventHandlers() {
            return {};
        },

        async fetchWeather() {
            const condition = await weather.forCoordinates(window.dashboard.openWeatherLat, window.dashboard.openWeatherLon);

            let icons = [];

            condition.weather
                .slice(0, 1) // There's not enough room for > 1 emoji -> only display the first weather condition
                .forEach(weatherCondition => {
                    const isNight = weatherCondition.icon.includes('n');

                    const icon = weather.getEmoji(weatherCondition.id, isNight);

                    icons.push(emoji(icon));
                });

            this.weather.temperature = condition.main.temp.toFixed(1);
            this.weather.icons = icons;
        },
    },
};
</script>

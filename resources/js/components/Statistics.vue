<template>
    <tile :position="position">
        <div class="grid gap-padding h-full markup">
            <ul class="align-self-center">
                <li>
                    <span>Unique Visitors</span>
                    <span class="font-bold variant-tabular">{{ formatNumber(uniqueVisitors) }}</span>
                </li>
                <li>
                    <span>Pageviews</span>
                    <span class="font-bold variant-tabular">{{ formatNumber(pageviews) }}</span>
                </li>
                <li>
                    <span>Average time on site</span>
                    <span class="font-bold variant-tabular">{{ formatDuration(avgTime) }}</span>
                </li>
                <li>
                    <span>Bounce rate</span>
                    <span class="font-bold variant-tabular">{{ formatPercentage(bounceRate) }}</span>
                </li>
                <li>
                    <span>Current Visitors</span>
                    <span class="font-bold variant-tabular">{{ formatNumber(currentVisitors) }}</span>
                </li>
            </ul>
        </div>
    </tile>
</template>

<script>
import { emoji, formatNumber } from '../helpers';
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            uniqueVisitors: 0,
            pageviews: 0,
            avgTime: 0,
            bounceRate: 0,
            currentVisitors: 0,
            uniqueVisitors: 0,
        };
    },

    methods: {
        emoji,
        formatNumber,

        formatDuration(sec) {
            let min = Math.floor(sec / 60);
            let seconds = sec - (min * 60);
            seconds = Math.floor(Math.round(seconds * 100) / 100)

            var result = (min < 10 ? "0" + min : min) + ':' + (seconds < 10 ? "0" + seconds : seconds);
            return result;
        },

        formatPercentage(number) {
            return number.toLocaleString("en", {style: "percent"})
        },

        getEventHandlers() {
            return {
                'Statistics.FathomTotalsFetched': response => {
                    this.uniqueVisitors = response.uniqueVisitors;
                    this.pageviews = response.pageviews;
                    this.avgTime = response.avgTime;
                    this.bounceRate = response.bounceRate;
                    this.currentVisitors = response.currentVisitors;
                    this.uniqueVisitors = response.uniqueVisitors;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'statistics',
            };
        },
    },
};
</script>

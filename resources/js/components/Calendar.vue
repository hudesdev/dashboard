<template>
    <tile :position="position">
        <div class="grid gap-padding h-full markup overflow-y-auto">
            <div v-if="todayEvents.length > 0">
                <h1>Today</h1>
                <ul>
                    <li v-for="(event, index) in todayEvents" :key="index">
                        <div class="my-2">
                            <div :class="{ 'font-bold': isNow(event.date, event.enddate) }">{{ event.name }}</div>
                            <div class="text-sm text-dimmed font">{{ formatTime(event.date, event.enddate, event.allDay) }}</div>
                        </div>
                    </li>
                </ul>
            </div>
            <div v-if="tomorrowEvents.length > 0">
                <h1>Tomorrow</h1>
                <ul>
                    <li v-for="(event, index) in tomorrowEvents" :key="index">
                        <div class="my-2">
                            <div :class="{ 'font-bold': isNow(event.date, event.enddate) }">{{ event.name }}</div>
                            <div class="text-sm text-dimmed">{{ formatTime(event.date, event.enddate, event.allDay) }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { formatTime, isNow, isToday } from '../helpers';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            events: [],
        };
    },

    computed: {
        todayEvents() {
            return this.events.filter(event => this.isToday(event.date))
        },
        tomorrowEvents() {
            return this.events.filter(event => !this.isToday(event.date))
        },
    },

    methods: {
        formatTime,
        isNow,
        isToday,

        getEventHandlers() {
            return {
                'Calendar.EventsFetched': response => {
                    this.events = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'calendar',
            };
        },
    },
};
</script>

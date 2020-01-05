<template>
    <tile :position="position" class="markup">
        <h1 v-if="sleep > 0">Fitness</h1>
        <div class="grid gap-padding" style="height: calc(100% - 13px);">
            <div class="flex flex-col items-center justify-center">
                <div class="flex items-center w-full" :class="{ 'flex-col flex-1 justify-center': ! sleep > 0, 'justify-between' : sleep > 0 }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M13.5 5.5c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zM9.8 8.9L7.24 21.81c-.13.61.35 1.19.98 1.19h.08c.47 0 .87-.32.98-.78L10.9 15l2.1 2v5c0 .55.45 1 1 1s1-.45 1-1v-5.64c0-.55-.22-1.07-.62-1.45L12.9 13.5l.6-3a7.321 7.321 0 004.36 2.41c.6.09 1.14-.39 1.14-1 0-.49-.36-.9-.85-.98-1.52-.25-2.78-1.15-3.45-2.33l-1-1.6a2.145 2.145 0 00-2.65-.84L7.22 7.78A2.01 2.01 0 006 9.63V12c0 .55.45 1 1 1s1-.45 1-1V9.6l1.8-.7" fill="currentColor"/></svg>
                    <span class="text-5xl" v-text="steps.toLocaleString('es-ES')"/>
                </div>
                <div v-if="sleep > 0" class="flex items-center w-full justify-between">
                    <svg width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" /></svg>
                    <span class="text-4xl" v-text="formatDuration(sleep)"/>
                </div>
            </div>
        </div>
    </tile>
</template>

<script>
import moment from 'moment';
import { formatNumber } from '../helpers';
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
            steps: 0,
            sleep: 0,
        };
    },

    methods: {
        formatNumber,

        formatDuration(seconds) {
            const duration = moment.duration(seconds, 'seconds')

            return `${duration.hours()}h ${duration.minutes()}m`
        },

        getEventHandlers() {
            return {
                'Fitness.StepsFetched': response => {
                    this.steps = response.steps;
                },
                'Fitness.SleepFetched': response => {
                    this.sleep = response.duration;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'fitness',
            };
        },
    },
};
</script>

<template>
    <tile v-if="hasFailingUrls" :position="position" class="markup bg-warn">
        <div class="grid gap-padding h-full markup" style="grid-template-rows: auto 1fr">
            <h1 style="color: var(--text-default)">Downtime</h1>
            <ul>
                <li v-for="(failing, index) in failingUrls" :key="index">
                    <div class="font-bold truncate">{{ failing.alias }}</div>
                </li>
            </ul>
        </div>
    </tile>
</template>

<script>
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import { formatDuration } from '../helpers';

export default {
    components: {
        Tile,
    },

    filters: {
        formatDuration,
    },

    mixins: [echo],

    props: ['position'],

    data() {
        return {
            failingUrls: [],
        };
    },

    computed: {
        hasFailingUrls() {
            return this.failingUrls.length > 0;
        },
    },

    methods: {
        getEventHandlers() {
            return {
                'Uptime.UptimeCheckFailed': response => {
                    this.add(response.site);
                },
                'Uptime.UptimeCheckRecovered': response => {
                    this.remove(response.site);
                },
                'Uptime.ClearingUptimeChecks': () => {
                    this.clear();
                },
            };
        },

        add(site) {
            this.failingUrls = this.failingUrls.filter(failingUrl => site.url !== failingUrl.url);

            this.failingUrls.push(site);
        },

        remove(site) {
            this.failingUrls = this.failingUrls.filter(failingUrl => site.url !== failingUrl.url);
        },

        clear() {
            this.failingUrls = []
        }
    },
};
</script>

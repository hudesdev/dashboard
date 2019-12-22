<template>
    <tile :position="position">
        <div class="grid gap-padding h-full markup">
            <div class="flex flex-col items-center justify-between">
                <span class="text-5xl" v-text="formatCurrency(mrr.total)"/>
                <ul class="w-full">
                    <li v-for="(value, name) in mrr.sources" :key="name">
                        <span v-text="name.replace(/^\w/, (c) => c.toUpperCase())"></span>
                        <span class="font-bold variant-tabular">{{ formatCurrency(value) }}</span>
                    </li>
                </ul>
            </div>
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
            mrr: {
                total: 0,
                sources: {},
            },
        };
    },

    methods: {
        emoji,

        formatCurrency(number) {
            return number.toLocaleString("en", { style: 'currency', currency:'USD' })
        },

        getEventHandlers() {
            return {
                'Statistics.MRRFetched': response => {
                    this.mrr = response.mrr;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'mrr',
            };
        },
    },
};
</script>

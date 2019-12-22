<template>
    <tile :position="position">
        <div
            class="grid gap-padding h-full markup"
            style="grid-template-columns: 100%;grid-template-rows: auto 1fr"
        >
            <div class="align-self-center" v-if="tasks.length">
                <ul>
                    <li class="flex justify-between" style="align-items:center;" v-for="(task, index) in tasks" :key="index">
                        <div class="truncate flex-1">
                            <p class="truncate" v-text="task.title"/>
                            <p v-if="task.project" class="flex-1 truncate text-xs text-dimmed" v-text="task.project"/>
                        </div>
                        <span class="font-bold variant-tabular" v-if="task.dueDate">Due {{ moment(task.dueDate).fromNow() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </tile>
</template>

<script>
import { emoji } from '../helpers';
import echo from '../mixins/echo';
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import moment from 'moment';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            tasks: [],
        };
    },

    methods: {
        emoji,
        moment,

        getEventHandlers() {
            return {
                'TickTick.TasksFetched': response => {
                    this.tasks = response.tasks;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: `tasks`,
            };
        },
    },
};
</script>

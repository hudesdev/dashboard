<template>
    <div
        class="fixed pin grid gap-spacing w-screen h-screen p-spacing font-normal leading-normal text-default bg-screen"
        :class="mode"
    >
        <slot></slot>
    </div>
</template>

<script>
import echo from '../mixins/echo';
import saveState from 'vue-save-state';

export default {
    mixins: [echo, saveState],

    data() {
        return {
            mode: 'dark-mode',
        };
    },

    methods: {
        getEventHandlers: () => ({}),
        getSaveStateConfig() {
            return {
                cacheKey: `dashboard`,
            };
        },
    },
};
</script>

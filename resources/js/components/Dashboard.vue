<template>
    <div
        class="fixed pin grid gap-spacing w-screen h-screen p-spacing font-normal leading-normal text-default bg-screen"
    >
        <slot></slot>
    </div>
</template>

<script>
import echo from '../mixins/echo';
import saveState from 'vue-save-state';

export default {
    mixins: [echo, saveState],

    methods: {
        getEventHandlers: () => ({
            'Dashboard.Refresh': () => {
                window.location.reload(true)
            },
        }),
        getSaveStateConfig: () => ({
            cacheKey: 'dashboard',
        }),
    },
};
</script>

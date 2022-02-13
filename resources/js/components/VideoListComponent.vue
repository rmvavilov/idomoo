<template>
    <ul class="list-group">
        <template v-if="videos.length">
            <li
                class="list-group-item d-flex justify-content-between align-items-center"
                v-for="video in videos"
                :key="video.id"
            >
                <span>
                    <strong>[{{ video.id }}]</strong>
                    <span>{{ video.name }}</span>
                </span>
                <template v-if="video.is_available">
                    <button
                        type="button"
                        class="btn btn-success btn-sm"
                        @click="playVideo(video.url)"
                    >
                        Play
                    </button>
                </template>
                <template v-else>
                    <strong>(Processing...)</strong>
                    <button
                        :disabled="video.hasOwnProperty('checking') && video.checking"
                        type="button"
                        class="btn btn-primary btn-sm"
                        @click="checkStatus(video.id)"
                    >
                        <template v-if="video.hasOwnProperty('checking') && video.checking">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </template>
                        <template v-else>
                            Recheck
                        </template>
                    </button>
                </template>
            </li>
        </template>
        <template v-else>no videos available</template>
    </ul>

</template>

<script>
export default {
    props: {
        videos: {
            type: Array,
            default: []
        },
    },

    methods: {
        playVideo(url) {
            this.$emit('play-video', url)
        },
        checkStatus(id) {
            this.$eventBus.$emit('check-video', id);
        },
    }
}
</script>

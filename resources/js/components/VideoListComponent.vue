<template>
    <ul class="list-group">
        <template v-if="videos.length">
            <li
                class="list-group-item d-flex justify-content-between align-items-center"
                v-for="video in videos"
                :key="video.id"
            >
                <span>{{ video.name }}</span>
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click="playVideo(video.url)"
                >
                    Play
                </button>
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
    }
}
</script>

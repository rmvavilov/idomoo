/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('video-list-component', require('./components/VideoListComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        autoplayFirstVideo: false,
        storyBoardData: [],
        videos: [],
        playerOptions: {
            src: '',
            interactive: true,
            size: "hd",
            autoplay: true,
        }
    },
    methods: {
        showGenerateVideoModal() {
            // this.getStoryBoardData();
        },
        playEvent(src) {
            this.initVideoPlayer(src);
        },
        playFirstVideo() {
            if (!this.autoplayFirstVideo) {
                return;
            }
            if (!this.videos.length) {
                return;
            }

            let firstVideo = _.first(this.videos),
                firstVideoSrc = _.get(firstVideo, 'url', '');

            if (!firstVideoSrc) {
                return;
            }

            this.initVideoPlayer(firstVideoSrc);
        },
        getVideos() {
            this.videos = [];
            axios
                .get(`/video/`,)
                .then((response) => {
                    let isSuccess = response.data.success;

                    if (isSuccess) {
                        this.videos = _.get(response.data, 'videos', []);
                        this.playFirstVideo();
                    } else {
                        //TODO: show error
                    }
                })
                .catch((e) => {
                    // show error
                });
        },
        getStoryBoardData() {
            this.storyBoardData = [];
            axios
                .get(`/video/create/`,)
                .then((response) => {
                    let isSuccess = response.data.success;

                    if (isSuccess) {
                        this.storyBoardData = _.get(response.data, 'data', []);
                    } else {
                        //TODO: show error
                    }

                })
                .catch((e) => {
                    // show error
                });
        },
        generateVideo() {
            axios
                .post('/video/', {
                    video_type: 'mp4',
                    height: 10,
                    data: [1]
                })
                .then((response) => {
                })
                .catch(() => {
                    // show error
                });
        },
        initVideoPlayer(src) {
            let playerId = 'idm',
                player = window[playerId];

            if (typeof player.dispose === 'function') {
                player.dispose();
            }

            this.playerOptions.src = src;
            idmPlayerCreate(this.playerOptions, playerId);
        },
    },
    mounted() {
        this.getVideos();
    },
});

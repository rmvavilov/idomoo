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
Vue.component('video-modal', require('./components/VideoGenerateComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.$eventBus = new Vue();

const app = new Vue({
    el: '#app',
    data: {
        showModal: false,
        autoplayFirstVideo: true,
        storyBoardName: '',
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
        closeModal() {
            this.showModal = false;
        },
        showGenerateVideoModal() {
            this.getStoryBoardData();
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

            let firstVideo = _.find(this.videos, {is_available: true}),
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
                        this.storyBoardName = _.get(response.data, 'name', '');
                        this.showModal = true;
                    } else {
                        //TODO: show error
                    }
                })
                .catch((e) => {
                    // show error
                });
        },
        checkVideoStatus(videoId) {
            let index = _.findIndex(this.videos, (videoObj) => {
                return videoObj.id == videoId;
            });
            if (index === -1) {
                return;
            }
            this.$set(this.videos[index], 'checking', true);

            axios
                .get('/video/' + videoId)
                .then((response) => {
                    this.videos[index].checking = false;
                    let isSuccess = response.data.success;
                    if (isSuccess) {
                        let newVideo = _.get(response.data, 'video', {});
                        Object.assign(this.videos[index], newVideo);
                    } else {
                        //TODO: show error
                    }
                })
                .catch(() => {
                    this.videos[index].checking = false;
                });
        },
        generateVideo(data) {
            axios
                .post('/video/', {
                    video_type: data.type,
                    quality: data.quality,
                    data: data.data
                })
                .then((response) => {
                    let isSuccess = response.data.success;
                    if (isSuccess) {
                        let newVideo = _.get(response.data, 'video', {});
                        this.videos.push(newVideo);
                        this.showModal = false;
                    } else {
                        //TODO: show error
                    }
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
    created() {
        this.$eventBus.$on('generate', (data) => {
            this.generateVideo(data);
        });

        this.$eventBus.$on('check-video', (id) => {
            this.checkVideoStatus(id);
        });
    },
    mounted() {
        this.getVideos();
    },
});

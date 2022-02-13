<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <span class="main-title">{{ name }}</span>
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Enter the details below in order to generate your video</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        @click="closeModal"></button>
                            </div>
                            <div class="modal-body">
                                <form class="row g-3" @submit="submitForm">
                                    <template v-for="dataItem in data">
                                        <div class="col-md-6">
                                            <label :for="'for-' + dataItem.key" class="form-label">{{
                                                    dataItem.key
                                                }}</label>
                                            <input class="form-control input-border" :id="dataItem.key">
                                        </div>
                                    </template>

                                    <!-- STANDART FIELDS : START -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="format" class="form-label">Format</label>
                                            <select id="format" class="form-select">
                                                <option value="mp4">MP4</option>
                                                <option value="hls">HLS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="resolution" class="form-label">Resolution</label>
                                            <select id="resolution" class="form-select">
                                                <option value="1280">1280x1280</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="quality" class="form-label">Quality</label>
                                            <select id="quality" class="form-select">
                                                <option v-for="index in 50" :key="index" :value="index" :selected="index=== 50">
                                                    {{ index }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- STANDART FIELDS : END -->

                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'VideoGenerateComponent',

    props: {
        isVisible: {
            type: Boolean,
            default: false
        },
        name: {
            type: String,
            default: ''
        },
        data: {
            type: Array,
            default: []
        },
    },

    methods: {
        closeModal() {
            this.$emit('close');
        },
        submitForm(e) {
            e.preventDefault();

            let data = {
                type: e.target.elements.format.value,
                quality: e.target.elements.quality.value,
                data: {},
            };
            _.each(this.data, (dataitem) => {
                let keyName = dataitem.key,
                    keyValue = _.get(e.target.elements, [keyName, 'value'], '');
                data.data[keyName] = keyValue
            });

            this.$eventBus.$emit('generate', data);
        },
    }
}
</script>

<style>

.form-control,
.form-select {
    color: #dde6ee;
    background-color: #6f97b7;
    border-radius: 8px;
    border: none;
}

.main-title {
    color: white;
    position: absolute;
    left: 15px;
    font-size: 18px;
    top: -40px;
}

.modal-title {
    font-size: 14px;
}

.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
    background-color: #004780;
}

.form-label {
    font-size: 10px;
}

.modal-content {
    background-color: #40759f;
    color: white;
    border: none;
}

.modal-container {
    border-radius: 8px;
    position: relative;
    width: 400px;
    min-width: 400px;
    margin: 0px auto;
    /*padding: 20px 30px;*/
    padding: 0;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header {
    padding: 33px 20px 0 10px;
    border: none;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}

</style>

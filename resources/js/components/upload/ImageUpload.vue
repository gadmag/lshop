<template>
    <div :id="name + '_component'" class="files_component">
        <div v-if="!isHideUpload()" :class="{'has-advanced-upload': isAdvanced}" ref="drop" class="box file_upload">
            <div  class="box_input">
                <svg v-if="attachments.length == 0" class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50"
                     height="43" viewBox="0 0 50 43">
                    <path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path>
                </svg>
                <div class="py-2">
                    <a href="#" v-on:click.prevent="$refs.fileInput.click()"><strong>Выберите файл</strong></a> <span>или перетащите сюда</span>
                </div>
                <image-preview v-if="!fast_upload" :files="attachments"
                               @close="deleteAttachment($event)"></image-preview>
                <input style="display: none" type="file" ref="fileInput" :multiple="allowMultiple" accept=""
                       @change="onFileSelected">
                <input type="hidden" v-bind:name="name" ref="fileUploaded" :id="name" value="">
                <div v-if="!fast_upload" class="mt-2">
                    <button :disabled="loading" class="btn btn-sm btn-primary" v-if="this.attachments.length > 0"
                            v-on:click.prevent="onSubmitUpload()">
                        <span v-if="loading" role="status" aria-hidden="true"
                              class="spinner-border spinner-border-sm"></span>
                        Загрузить на сервер
                    </button>
                </div>
            </div>
        </div>
        <image-preview :files="previews" @close="deletePreview($event)"></image-preview>
    </div>
</template>

<script>
    import ImagePreview from './ImagePreview.vue'

    export default {
        components: {
            ImagePreview
        },
        props: {
            name: {
                default: 'Uploaded',
                type: String
            },
            files: '',
            action: '',
            label: '',

            'allowMultiple': {
                type: Boolean,
                default: true
            },
            acceptedFileTypes: "image/*"
        },

        data() {
            return {
                fast_upload: true,
                isAdvanced: false,
                uploadPercentage: 0,
                loading: false,
                previews: [],
                attachments: [],
                value: ''
            }

        },
        mounted() {
            this.isAdvanced = this.isAdvancedUpload();
            if (this.isAdvanced) {
                ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (evt) {
                    this.$refs.drop.addEventListener(evt, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }.bind(this), false);
                }.bind(this));
                this.$refs.drop.addEventListener('drop', function (e) {
                    for (let i = 0; i < e.dataTransfer.files.length; i++) {
                        if (!this.allowMultiple && (i > 0) ) break;
                        this.attachments.push(e.dataTransfer.files[i]);
                    }
                    if (this.fast_upload) {
                        this.onSubmitUpload();
                    }
                }.bind(this));
            }
        },
        created() {

            if (this.files && this.files.length > 0) {
                this.previews = this.files;
            }
        },
        watch: {
            'previews': 'assignUploaded'
        },
        methods: {
            isAdvancedUpload() {
                let div = document.createElement('div');
                return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div))
                    && 'FormData' in window && 'FileReader' in window;

            },
            onSubmitUpload() {
                this.loading = true;
                let formData = new FormData();
                for (let i = 0; i < this.attachments.length; i++) {
                    formData.append('files[' + i + ']', this.attachments[i]);
                }
                axios.post(this.action, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',

                        },
                        onUploadProgress: function (progressEvent) {
                            this.uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
                        }.bind(this)
                    },
                ).then(function (response) {
                    this.previews = _.concat(this.previews, response.data.uploads);

                }.bind(this))
                    .catch(function (error) {
                        console.log('FAILURE!!', error);
                    })
                    .finally(() => {
                        this.attachments = [];
                        // this.$refs.fileInput.value = '';
                        this.loading = false;
                    });

            },
            onFileSelected(e) {
                const files = e.target.files;
                if (files && files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        if (!this.allowMultiple && (i > 0) ) break;
                        this.attachments.push(files[i]);
                    }
                    this.$emit('input', this.attachments);
                    this.onSubmitUpload();
                }
            },
            isHideUpload(){
              return (!this.allowMultiple && this.previews.length > 0)
            },
            assignUploaded() {
                if (this.previews.length > 0) {
                    this.$refs.fileUploaded.value = _.map(this.previews, 'id').join(",");
                    this.$emit('getFiles', _.map(this.previews, 'name'));
                } else {
                    this.$refs.fileUploaded.value = '';
                }
            },
            deleteAttachment(key) {
                this.attachments.splice(key, 1)

            },
            deletePreview(key) {
                this.previews.splice(key, 1)
            }
        }
    }
</script>
<style>

    .files_component {
        /*margin: 0 auto;*/
        max-width: 500px;
    }

    .file_upload.has-advanced-upload {
        clear: both;
        outline: 2px dashed rgba(0, 38, 59, 0.21);
        outline-offset: -10px;
        -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
        transition: outline-offset .15s ease-in-out, background-color .15s linear;
    }

    .files_component .box {
        background-color: #f7f7f7;
        position: relative;
        padding: 100px 20px;
    }

    .files_component .box_input {
        position: relative;
        text-align: center;
        font-size: 18px;
    }

    .files_component .box.has-advanced-upload .box__icon {
        width: 100%;
        height: 80px;
        fill: #92b0b3;
        display: block;
        margin-bottom: 20px;
    }

    .file_upload.has-advanced-upload .box__dragndrop {
        display: inline;
    }

    /**/
    .list_preview {
        display: flex;
        flex-wrap: wrap;
    }

    .preview-file {
        width: 100px;
        transition: opacity 0.15s ease-out;
        background: #E6E6E6;
        position: relative;
        margin: 10px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);

    }

    .box_input .preview-file {
        background: #F2F7ED;
        box-shadow: 0px 4px 4px rgba(188, 191, 184, 0.35);
    }

    .preview-file .img-box {
        padding: 0.5rem;
        text-align: center;
    }

    .preview-file .img-preview {
        width: 100%;
        max-height: 80px;
    }

    .preview-file .preview-delete {
        position: absolute;
        right: 5px;
        top: 5px;
        z-index: 102;
    }

    div.preview-delete button.remove {

        color: #ffffff;
        font-size: 1em;
        font-family: inherit;
        line-height: inherit;
        margin: 0;
        padding: 0;
        border: none;
        outline: none;
        will-change: transform, opacity;
        width: 1.625em;
        height: 1.625em;
        cursor: pointer;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, .5);
        background-image: none;
        box-shadow: 0 0 0 0 hsla(0, 0%, 100%, 0);
        transition: box-shadow .25s ease-in;
    }

    div.preview-delete button.remove:hover {
        box-shadow: 0 0 0 0.125em hsla(0, 0%, 100%, .9);
    }

    button.remove svg {
        width: 100%;
        height: 100%;
    }

    .preview-file-info {
        text-align: left;
        padding: 0.7rem 0.3em;
        position: static;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        /*margin: 0 .5em 0 .5em;*/
        min-width: 0;
        will-change: transform, opacity;
        pointer-events: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .preview-file-info .file-info-name {
        /*color: #ffffff;*/
        font-size: .85em;
        line-height: 1.2;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }

    .preview-file-info .file-info-sub {
        /*color: #ffffff;*/
        font-size: .725em;
        opacity: .5;
        transition: opacity .25s ease-in-out;
        white-space: nowrap;
    }

    img.loading-img {
        position: absolute;
        top: 30%;
        left: 0;
        right: 0;
        margin: 0 auto;
        display: block;
    }
</style>
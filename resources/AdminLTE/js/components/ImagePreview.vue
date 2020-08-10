<template>
    <div class="list_preview">
        <div v-for="(file, key) in files" class="preview-file">
            <div class="preview-delete">
                <button class="remove" type="button" v-on:click="removeFile( key )">
                    <svg width="26" height="26" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.586 13l-2.293 2.293a1 1 0 0 0 1.414 1.414L13 14.414l2.293 2.293a1 1 0 0 0 1.414-1.414L14.414 13l2.293-2.293a1 1 0 0 0-1.414-1.414L13 11.586l-2.293-2.293a1 1 0 0 0-1.414 1.414L11.586 13z"
                              fill="currentColor" fill-rule="nonzero"></path>
                    </svg>
                </button>
            </div>
            <div class="img-box">
<!--                <span :style="{displaySpinner: 'display: none'}" role="status" aria-hidden="true"-->
<!--                      :ref="`spinner-preview` + parseInt( key )" class=" spinner-border spinner-border-sm"></span>-->
                <img class="img-preview" v-bind:ref="'preview'+parseInt( key )"/>
            </div>
            <div class="preview-file-info">
                <span class="file-info-name" v-if="file.name">{{ file.name }}</span>
                <span class="file-info-sub" v-if="file.size">{{(file.size / 1024).toFixed(2) }} KB</span>
            </div>

        </div>
    </div>
</template>

<script>

    export default {
        name: "ImagePreview",
        props: {
            files: '',
            path: {
                type: String,
                default: '/storage/files/thumbnail/',
            }
        },
        data() {
            return {

            }
        },
        mounted() {
            this.setPreviews();
        },

        watch: {
            'files': 'setPreviews'
        },

        methods: {

            setPreviews() {
                for (let i = 0; i < this.files.length; i++) {
                    if (this.files[i] instanceof File) {
                        if (this.isImage(this.files[i].name)) {
                        // document.querySelector('.spinner-preview' + parseInt(i)).style.display = "block";
                        // this.$refs['spinner-preview' + parseInt(i)][0].displaySpinner = "block";
                        const fileReader = new FileReader()
                        fileReader.onloadstart = (event) => {
                            // this.$refs['spinner-preview' + parseInt(i)][0].displaySpinner = "display: block";
                        }
                        fileReader.onload = (event) => {
                            // this.$refs['spinner-preview' + parseInt(i)][0].displaySpinner = "display: none";
                            this.$refs['preview' + parseInt(i)][0].src = event.target.result;
                        }


                            fileReader.readAsDataURL(this.files[i]);
                        }else {
                            this.$nextTick(function () {
                                this.$refs['preview' + parseInt(i)][0].src = '/img/document.png';
                            });
                        }


                    } else if (typeof this.files[i] === 'object') {
                        this.$nextTick(function () {
                            if (this.isImage(this.files[i].name)){
                                console.log(this.files[i].name);
                                this.$refs['preview' + parseInt(i)][0].src = `/storage/files/thumbnail/${this.files[i].name}`;
                            } else {
                                this.$refs['preview' + parseInt(i)][0].src = '/img/document.png';
                            }
                        });

                    } else {
                        this.$nextTick(function () {
                            this.$refs['preview' + parseInt(i)][0].src = '/img/document.png';
                        });

                    }

                }
            },

            isImage(name){
                return /\.(jpe?g|png|gif)$/i.test(name);
            },

            removeFile (key) {
                this.$emit('close', key);
            }
        }
    }
</script>

<style scoped>

</style>
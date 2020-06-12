<template>
    <v-form
        class="media-upload"
        ref="form"
        @submit="submit"
    >
        <v-row justify="center">
            <v-col
                cols="12"
                md="8"
                sm="10"
            >
                <v-card class="pa-5">
                    <input type="file" name="select_img" id="select_img" class="hidden"
                           @change="userSelectImage" accept="image/*">
                    <label for="select_img" ref="fileLabel" @dragover.stop="imageDraggedIn=1"
                           @dragleave.stop="imageDraggedIn=0"
                           @drop.stop="imageDraggedIn=0">

                        <div :class="['upload-box',{'img-dragged-in':imageDraggedIn==1}]">


                            <v-col
                                justify-center
                                cols="12"
                                md="8"
                                sm="8"
                            >
                                <div class="m-title">
                                    فایلتون رو اینجا بگشید یا کلیک کنید
                                </div>
                            </v-col>
                        </div>
                    </label>
                </v-card>
                <v-card class="mt-5" v-if="serverImages.length">
                    <v-row justify="space-around">
                        <v-col cols="12">
                            <template v-for="image in serverImages">
                                <div class="title mb-1">image.title</div>
                                <v-img :src="image.url" aspect-ratio="1.7"></v-img>
                            </template>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
        <v-snackbar
            v-model="snackbar"
        >
            {{ snackbarText }}
            <v-btn
                color="pink"
                text
                @click="snackbar = false"
            >
                x
            </v-btn>
        </v-snackbar>
    </v-form>
</template>

<script>
    export default {
        name: "MediaCreate",
        data() {
            return {
                serverImages: [],
                localImages: [],
                singleUploadPercentages: [],
                snackbar: false,
                imageDraggedIn: false,
                snackbarText: 'snackbarText',
                maximum_images_count: 5,
            }
        },
        snc(text) {
            this.snackbar = true;
            this.snackbarText = text;
        },
        methods: {
            checkValidFile(item, callback) {
                const fileType = item['type'];
                var ValidImage = true;
                const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'];
                var image = new Image();
                image.onload = function () {
                    return proceed();
                };
                image.onerror = function () { //this can somehow check mimetype
                    ValidImage = false;
                    return proceed();

                };
                var url = window.URL || window.webkitURL;
                image.src = url.createObjectURL(item);

                function proceed() {
                    if (!validImageTypes.includes(fileType) || !ValidImage) {
                        this.snc('فایل مورد نظر شما معتبر نیست')
                        return false;
                    }
                    if (item.size > (20 * 1024 * 1024)) {
                        toastr.error(window.err_img_size);
                        this.snc('فایل مورد نظر شما از 20 مگابایت بزرگتر است')
                        return false;
                    }
                    callback(); //return true;
                };

            },
            userSelectImage(e) {
                if (e.target.files[0]) {
                    for (let item of e.target.files) {
                        this.checkValidFile(item, () => {
                            this.localImages.push(item);

                            let formData = new FormData();

                            formData.append('item', item);
                            $.ajax({
                                url: '/admin/contents/media/upload',
                                data: formData,
                                enctype: 'multipart/form-data',
                                processData: false,
                                contentType: false,
                                type: 'POST',
                                xhr: () => {
                                    // get the native XmlHttpRequest object
                                    var xhr = $.ajaxSettings.xhr();
                                    // set the onprogress event handler
                                    xhr.upload.onprogress = evt => {
                                        this.singleUploadPercentages = Math.round(evt.loaded / evt.total * 100);
                                    };
                                    // set the onload event handler
                                    xhr.upload.onload = function () {
                                        console.log('DONE!')
                                    };
                                    // return the customized object
                                    return xhr;
                                },
                                success: (response) => {
                                    console.log(response);

                                    this.singleUploadPercentages = 0;
                                    // this.$store.state.form.media.push(response.media);

                                },
                                error: (error, xhr) => {
                                    // this.$store.commit('showModal', false)
                                }
                            }).always(() => {
                                // toastr.clear();
                                // $('#submit-crop').removeAttr('disabled');

                            });
                        })
                    }
                }
                document.getElementById("select_img").value = null;
            },
            determineDragAndDropCapable() {
                /*
                  Create a test element to see if certain events
                  are present that let us do drag and drop.
                */
                var div = document.createElement('div');

                /*
                  Check to see if the `draggable` event is in the element
                  or the `ondragstart` and `ondrop` events are in the element. If
                  they are, then we have what we need for dragging and dropping files.

                  We also check to see if the window has `FormData` and `FileReader` objects
                  present so we can do our AJAX uploading
                */
                return (('draggable' in div)
                    || ('ondragstart' in div && 'ondrop' in div))
                    && 'FormData' in window
                    && 'FileReader' in window;
            },
            mountDragAndDrop() {
                /*
                  Determine if drag and drop functionality is capable in the browser
                */
                this.dragAndDropCapable = this.determineDragAndDropCapable();

                /*
                  If drag and drop capable, then we continue to bind events to our elements.
                */
                if (this.dragAndDropCapable) {
                    /*
                      Listen to all of the drag events and bind an event listener to each
                      for the fileLabel.
                    */
                    ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(evt => {
                            /*
                              For each event add an event listener that prevents the default action
                              (opening the file in the browser) and stop the propagation of the event (so
                              no other elements open the file in the browser)
                            */

                            this.$refs.fileLabel.addEventListener(evt, e => {
                                e.preventDefault();
                                e.stopPropagation();
                            }, false);
                        }
                    );

                    /*
                      Add an event listener for drop to the form
                    */

                    this.$refs.fileLabel.addEventListener('drop', e => {
                        /*
                          Capture the files from the drop event and add them to our local files
                          array.
                        */

                    });
                }
            },
            submit() {
            },
        },
        mounted() {
            this.mountDragAndDrop();
        }
    }
</script>

<style scoped>
    .upload-box {
        border: 2px dashed #ccc;
        height: 150px;
    }
</style>

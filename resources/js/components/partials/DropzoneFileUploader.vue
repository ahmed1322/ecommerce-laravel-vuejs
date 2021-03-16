<template>
    <div>
        <div class="dropzone">
            <div class="dropzone-file-uploader" ref="imageUpload">

            </div>
        </div>

        <button  @click="fireUploader()" class="btn btn-link btn-block">
            Upload Cover
        </button>
    </div>
</template>

<script>
import "bs-dropzone/dist/min/dropzone.min.css";
import Dropzone from "bs-dropzone/dist/min/dropzone.min.js";

export default {
    name: "DropzoneFileUploader",

    props: {
        name: {
            type: String,
            require: true
        },

        multiple: {
            type: Boolean
        },

        url: {
            type: String,
            require: true
        },

        maxFiles: {
            type: Number
        },

        bus: {
            type: Object

        }
    },

    data() {
        return {
            dropzone: null,
            productId: null,
            dropzoneOption: {}
        };
    },

    methods: {
        setDropZoneOption() {
            return {
                paramName: this.name,
                autoProcessQueue: false,
                url: this.url + this.productId,
                parallelUploads: 10,
                addRemoveLinks: true,
                maxFiles: 1,
                maxFilesize: 256,
                acceptedFiles: ".jpeg,.jpg,.png",
                method: "POST",
                headers: {
                    Authorization: `Bearer ${localStorage.getItem(
                        "access_token"
                    )}`
                }

            };
        },

        fireUploader() {
            this.$refs.imageUpload.click();
        },

        uploadFiles(){
            this.dropzone.processQueue();
        },

        initDropzone(product){

            let options = this.setDropZoneOption();

            this.productId = product.id

            options.url = this.url + product.id;

            if (this.maxFiles != undefined) {
                options.maxFiles = this.maxFiles;
            } else {
                options.maxFiles = 1;
            }

            this.dropzone = new Dropzone(this.$refs.imageUpload, options);

        },

    },

    mounted() {

        this.bus.$on('retrievedProduct', this.initDropzone)

        this.bus.$on('attamptUpdate', this.uploadFiles)

    }
};
</script>

<style scope>
.dropzone .dz-preview {
    margin: 5px;
    width: 45%;
    border: 1px solid #bdbdbd;
    min-height: auto;
}

.dropzone .dz-preview .dz-image {
    border-radius: 0;
}

.dropzone .dz-preview .dz-image {
    width: 100%;
    height: 100%;
}

.dropzone .dz-preview .dz-image img {
    display: block;
    width: 100%;
}

.dropzone .dz-preview .dz-remove {
    position: absolute;
    top: -8px;
    left: -14px;
    z-index: 10;
    width: 30px;
    height: 25px;
    border-radius: 10px;
    font-size: 20px;
    overflow: hidden;
}

.dropzone .dz-preview .dz-remove:before {
    content: '\f057';
    font-family: "Font Awesome 5 Free";
    display: block;
    width: 100%;
    margin-right: 5px;
    color: #f00;
}

.dropzone .dz-preview .dz-progress{
    opacity: 0;
}
</style>

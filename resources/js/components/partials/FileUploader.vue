<template>
  <div class="card card-body">
    <input
        type="file"
        :name="name"
        :multiple="multiple"
        v-bind:id="name"/>
  </div>
</template>

<script>

import * as FilePond from "filepond";

// Import Vue FilePond
import vueFilePond from "vue-filepond";

// Import FilePond styles
import "filepond/dist/filepond.min.css";

// Import FilePond plugins
// Please note that you need to install these plugins separately
// Import image preview plugin styles
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

// Create component
const assetFilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default {
    name: "FileUploader",

    props: {

        inputId: {
            type: String,
            require: true
        },

        name: {
            type: String,
            require: true
        },

        multiple: {
            type: Boolean
        },

        server_url: {
            type: String,
            require: true
        }


    },

    methods:{
        init(){
            const inputElement = document.querySelector(`input[name=${this.name}]`);
            const pond = FilePond.create( inputElement );
        },

        setOptions(){
            FilePond.setOptions({
                server:{
                    url: this.server_url,
                    // url: '/api/v1/upload',
                    headers: {
                        'Authorization' : `Bearer ${localStorage.getItem("access_token")}`
                    },
                }
            });

        },



    },

    mounted: function() {
        this.init();
        this.setOptions();
    },

};
</script>

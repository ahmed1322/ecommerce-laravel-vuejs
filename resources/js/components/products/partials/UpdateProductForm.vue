<template>
    <form @submit.prevent enctype="multipart/form-data">
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input
                        :class="[errors.name ? 'is-invalid' : '']"
                        type="text"
                        class="form-control form-control-lg"
                        id="product_name"
                        placeholder="product Name"
                        v-model="product.name"
                    />
                    <span
                        v-if="errors.name"
                        class="invalid-feedback"
                        role="alert"
                    >
                        <strong>{{ errors.name[0] }}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <label for="price">Product Price</label>
                    <input
                        :class="[errors.price ? 'is-invalid' : '']"
                        type="number"
                        class="form-control form-control-lg"
                        id="price"
                        placeholder="Product Price"
                        v-model="product.price"
                    />
                    <span
                        v-if="errors.price"
                        class="invalid-feedback"
                        role="alert"
                    >
                        <strong>{{ errors.price[0] }}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <label for="color">Product Colors</label>
                    <input
                        :class="[errors.color ? 'is-invalid' : '']"
                        type="text"
                        class="form-control form-control-lg"
                        id="color"
                        placeholder="Product Color"
                        v-model="product.color"
                    />
                    <span
                        v-if="errors.color"
                        class="invalid-feedback"
                        role="alert"
                    >
                        <strong>{{ errors.color[0] }}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <label for="sizes">Product Sizes</label>
                    <input
                        :class="[errors.size ? 'is-invalid' : '']"
                        type="text"
                        class="form-control form-control-lg"
                        id="sizes"
                        placeholder="Product Sizes"
                        v-model="product.size"
                    />
                    <span
                        v-if="errors.size"
                        class="invalid-feedback"
                        role="alert"
                    >
                        <strong>{{ errors.size[0] }}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <label for="stock_quantity">Product Stock Quantity</label>
                    <input
                        :class="[errors.stock_quantity ? 'is-invalid' : '']"
                        type="number"
                        class="form-control form-control-lg"
                        id="stock_quantity"
                        placeholder="Product Stock Quantity"
                        v-model="product.stock_quantity"
                    />
                    <span
                        v-if="errors.stock_quantity"
                        class="invalid-feedback"
                        role="alert"
                    >
                        <strong>{{ errors.stock_quantity[0] }}</strong>
                    </span>
                </div>

                <div class="card card-body">
                    <div class="d-flex align-items-center">
                        <div class="switch w-100">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input
                                        type="checkbox"
                                        id="switch-1"
                                        true-value="1"
                                        false-value="0"
                                        v-model="product.availability"
                                    />
                                    <span
                                        v-if="errors.availability"
                                        class="invalid-feedback"
                                        role="alert"
                                    >
                                        <strong>{{
                                            errors.availability[0]
                                        }}</strong>
                                    </span>
                                    <label for="switch-1"></label>
                                </div>
                                <div class="col-lg-6">
                                    <label>Product Availability</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-4 offset-lg-1">
                <div class="form-group" v-if="product.product_cover">
                    <img
                        height="150"
                        class="img-thumbnail"
                        v-bind:src="product.product_cover"
                        :alt="product.name"
                    />

                    <button class="btn btn-link btn-block mt-2">Change Cover</button>
                </div>

                <div class="form-group" v-if="product.product_gallery">

                    <div class="card card-body">

                        <div class="row">

                                <div class="col-lg-4" v-for="( gallery_item, index ) in product.product_gallery " :key="index">

                                    <div class="product_gallery_item">
                                        <img
                                        class="img-thumbnail"
                                        v-bind:src="gallery_item"
                                        :alt="product.name"
                                        />
                                    </div>

                                </div>

                        </div>
                    </div>

                    <button class="btn btn-link btn-block mt-2">Add more to Gallery</button>
                </div>

                <file-uploader
                    inputId="product_cover"
                    name="product_cover"
                    server_url="/api/v1/products/upload"
                    :multiple="false"
                ></file-uploader>



                <file-uploader
                    inputId="product_gallery"
                    name="product_gallery"
                    server_url="/api/v1/products/upload"
                    :multiple="true"
                ></file-uploader> -->

            <div class="col-lg-4">
                <div class="form-group">
                    <DropzoneFileUploader
                        name="product_cover"
                        url="/api/v1/products/upload/"
                        :multiple='false'
                        :bus="bus"

                    ></DropzoneFileUploader>
                </div>

                <div class="form-group">
                    <DropzoneFileUploader
                        name="product_gallery"
                        url="api/v1/products/upload/"
                        :maxFiles='5'
                        :bus="bus"

                    ></DropzoneFileUploader>
                </div>
            </div>
        </div>
        <!-- </div> -->

        <button type="button" @click="attamptUpdate()" class="btn btn-primary">
            Update
        </button>
    </form>
</template>

<script>
// import Vue from 'vue';
import DropzoneFileUploader from "../../partials/DropzoneFileUploader";
import FileUploader from "../../partials/FileUploader";

export default {
    name: "UpdateProductForm",

    components: {
        FileUploader,
        DropzoneFileUploader
    },

    props: {
        update_product_route: {
            type: String,
            require: true
        },

        bus: {
            type: Object
        }
    },

    data() {
        return {
            errors: {},
            product:{},
        };
    },

    methods: {
        attamptUpdate() {
            // this.$emit("attamptUpdate");
            // this.$children.$emit("attamptUpdate")
            this.bus.$emit('attamptUpdate')
            this.$emit('updateProduct', {
                name: 'name'
            })
        },

        setProduct(product){
            this.product = product
        },

        handleFilePondInit: function() {
            console.log("init");
        }
    },

    mounted(){
        this.bus.$on('retrievedProduct', this.setProduct)
    }
};
</script>

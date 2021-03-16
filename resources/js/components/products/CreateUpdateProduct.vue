<template>
    <update-product-form
        :product="product"
        :product_route="product_route"
        :update_product_route="update_product_route"
        :bus="bus"
        @updateProduct="updateProduct"
    ></update-product-form>
</template>

<script>
import Vue from 'vue';

import UpdateProductForm from "./partials/UpdateProductForm";

export default {
    name: "CreateUpdateProduct",

    props: ["product_route", "update_product_route", ],

    components: {
        UpdateProductForm
    },

    data() {
        return {
            bus: new Vue(),
            product: {}
        };
    },

    methods: {
        getProduct() {
            axios
                .get(this.product_route)
                .then(res => {
                    this.product = res.data.data;
                    this.bus.$emit( 'retrievedProduct', this.product );
                })
                .catch(err => console.log(err));
        },

        attamptUpdate(){

            console.log({
                name: this.product.name,
                    price: this.product.price,
                    color: this.product.color,
                    size: this.product.size,
                    stock_quantity: this.product.stock_quantity,
                    availability: this.product.availability,
                    product_images: document.querySelector('input[name=product_cover]').value
            });
            axios
                .put(this.update_product_route, {
                    name: this.product.name,
                    price: this.product.price,
                    color: this.product.color,
                    size: this.product.size,
                    stock_quantity: this.product.stock_quantity,
                    availability: this.product.availability,
                    // product_gallery: document.querySelector('input[name=product_gallery]').value,
                    product_cover: document.querySelector('input[name=product_cover]').value
                })
                .then(res => {
                    window.location.href = res.data.data.route;
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                    console.log(err.response);
                });
        },

        updateProduct(){
            console.log('updateProduct');
        }
    },

    mounted: function() {
        this.getProduct();
    }
};
</script>

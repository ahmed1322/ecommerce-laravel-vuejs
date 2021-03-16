<template>
    <!-- Content Wrapper START -->
    <div>
        <div class="mb-5">
            <span class="alert alert-success d-block text-center" v-if="msg">{{ msg }}</span>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="m-t-25">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Stock Quantity</th>
                                <th>Avability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, index) in seller_products" :key="index">
                                <td>{{ product.name }}</td>
                                <td>{{ product.color }}</td>
                                <td>{{ product.size }}</td>
                                <td>{{ product.stock_quantity }}</td>
                                <td v-if="product.availability == true">
                                    Available
                                </td>
                                <td v-else>Not Available</td>
                                <td>
                                    <a
                                        class="btn btn-success"
                                        :href="product.edit_route"
                                        >Edit</a
                                    >
                                    <a
                                        @click.prevent="deleteProduct(product.delete_route, index)"
                                        class="btn btn-danger"
                                        :href="product.delete_route"
                                        >Delete</a
                                    >
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Product Name</th>
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Stock Quantity</th>
                                <th>Avability</th>
                                <!-- <th>Sales</th> -->
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Wrapper END -->
</template>

<script>
import axios from "axios";
export default {
    name: "SellerProducts",
    props: ["seller_products_route"],
    data() {
        return {
            msg: '',
            seller_products: {}
        };
    },

    methods: {
        getProducts() {
            axios
                .get(this.seller_products_route)
                .then(res => {
                    this.seller_products = res.data.data.response;
                })
                .catch(err => console.log(err));
        },

        deleteProduct(delete_uri, index){
            this.$confirm("Are you sure?").then(() => {
                axios
                    .delete(delete_uri)
                    .then(res => {
                        // console.log();
                        this.seller_products.splice( index , 1 )
                        return res.data.msg;
                    }).then( res => {
                        this.msg = res

                        setTimeout(() => {
                           this.msg = ''
                        }, 2000);
                    })
                    .catch(err => console.log(err));
            });


        }
    },

    mounted: function() {
        this.getProducts();
    }
};
</script>

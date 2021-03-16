/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = localStorage.getItem("access_token");

if (token) {
    window.axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}


/**
 * We'll load the Vuejs components
 */

// window.Vue = require('vue');
// Vue.component('LoginComponent',
//     require('./components/auth/LoginComponent.vue').default);
import Vue from "vue";
import VueSimpleAlert from "vue-simple-alert";
Vue.use(VueSimpleAlert);
import LoginComponent from "./components/auth/LoginComponent.vue";
import RegisterComponent from "./components/auth/RegisterComponent.vue";
import SellerProducts from "./components/products/SellerProducts.vue";
import CreateUpdateProduct from "./components/products/CreateUpdateProduct.vue";

window.onload = () => {
    const app = new Vue({
        el: "#app",
        components: {
            LoginComponent,
            RegisterComponent,
            SellerProducts,
            CreateUpdateProduct
        },
    });
};

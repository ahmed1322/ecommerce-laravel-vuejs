/**
 * We'll load the Vuejs components
 */

// window.Vue = require('vue');
// Vue.component('LoginComponent',
//     require('./components/auth/LoginComponent.vue').default);

import Vue from "vue";
import LoginComponent from "./components/auth/LoginComponent.vue";
import RegisterComponent from "./components/auth/RegisterComponent.vue";

window.onload = () => {
    const app = new Vue({
        el: "#app",
        components: {
            LoginComponent,
            RegisterComponent
        },
    });
};

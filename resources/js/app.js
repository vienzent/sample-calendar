require('./bootstrap');

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import VueSweetalert2 from 'vue-sweetalert2';
import Swal from 'sweetalert2'

Vue.use(VueSweetalert2);

Vue.use(BootstrapVue)

Vue.use(IconsPlugin)

import App from './App.vue';

const app = new Vue({
    el: '#app',
    components: {
        App
    }
});

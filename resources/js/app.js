require('./bootstrap');
import Vue from 'vue'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
window.Vue = require('vue');
import '@fortawesome/fontawesome-free/css/all.css'



// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


import Router  from './routes/route'
const app = new Vue({
    router:Router,
    el: '#app',
});

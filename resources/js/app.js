import Vue from 'vue';
import AppNasa from "./components/NasaTable/AppNasa";

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components:{
        AppNasa
    }
});


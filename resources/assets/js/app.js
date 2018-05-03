
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

global.Vue   = Vue;
global.axios = axios;
global.Vuex  = Vuex;

require('./bootstrap.js');

import Store from './lib/store.js';
import List from './components/list.vue';

import server from './lib/server.js';
//import Server from './lib/fake-server';
//var server = Server({
//    responseDelay: 2000
//});

var store = Store({
    server: server
});

const app = new Vue({
    el: '#app',
    store: store,
    components: {
        List
    },
});

app.$store.dispatch('fetch');

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Login from './components/login';
import Home from './components/HomeComponent';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.use(VueRouter);

const routes = [
    {path:'/', redirect:'/home'},
    {path:'/home', component:Home},
    {path:'/login', component:Login}
]

const router = new VueRouter({
    routes
})

Vue.component('login', Login)
Vue.component('home', Home)

const store = new Vuex.Store({
    state: {
      token: "",
      user: null,
      loggedin: false
    },
    mutations: {
      setToken(state, received_token) {
          state.token = received_token;
      },
      logIn(state, boll) {
        state.loggedin = boll;
      }
    },
    getters: {
        token: state => state.token,
        loggedin: state => state.loggedin
      }
});

const app = new Vue({
    el: '#app',
    router,
    store,
    data: {
    },mounted(){
        const token = localStorage.getItem("token")
        if(token != null){
            this.$store.commit('setToken',token);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
        }
    },methods:{
        logout(){
            this.$store.commit('setToken',"");
            this.$store.commit('logIn', false);
            axios.defaults.headers.common.Authorization = null;
        },
        isLoggedIn(){
            if(this.$store.getters.loggedin){
                return true
            }
            return false
        }
    }
});

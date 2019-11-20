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
    {path:'/login', component:Login}//,
    //{path: '/users/profile', component: profile, name: 'profile'},
]

const router = new VueRouter({
    routes
})

Vue.component('login', Login)
Vue.component('home', Home)
//Vue.component('profile', Profile)

const store = new Vuex.Store({
    state: {
      token: "",
      user: null,
      loggedin: false
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setToken(state, received_token) {
            state.token = received_token;
        },
        logIn(state, boll) {
        state.loggedin = boll;
        }
    },
    getters: {
        token: state => state.token,
        loggedin: state => state.loggedin,
        user: state => state.user
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
            axios.get('/api/getAuthUser')
                .then(response => {
                    this.$store.commit('setUser',response.data);
                });
        }
    },methods:{
        logout(){
            this.$store.commit('setUser',null);
            this.$store.commit('setToken',"");
            this.$store.commit('logIn', false);
            axios.defaults.headers.common.Authorization = null;
            localStorage.clear();
        },
        isLoggedIn(){
            if(this.$store.getters.loggedin){
                return true
            }
            return false
        }
    }
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueGoodTable from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css';
import Login from './components/login';
import Profile from './components/users/profile';
import Home from './components/HomeComponent';
import RegisterUser from './components/users/registerUser';
import Operator from './components/operator/OperatorComponent';
import Users from './components/users/users';
import listVirtualWallets from './components/wallets/wallets';
import Movements from './components/movements/movements';

import Vuex from 'vuex';

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueGoodTable);

const routes = [
    {path:'/', redirect:'/home'},
    {path:'/home', component:Home},
    {path:'/login', component:Login},
    {path:'/register', component:RegisterUser},
    {path: '/profile', component:Profile, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")==null){
            next("/home");
        }else{
            next();
        }
    }},
    {path: '/myVirtualWallets', component:listVirtualWallets, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")==null){
            next("/");
        }else{
            next();
        }
    }},
    {path: '/operator', component:Operator, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")==null){
            next("/");
        }else{
            next();
        }
    }},
    {path: '/movements', component:Movements, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")==null){
            next("/");
        }else{
            next();
        }
    }},

]

const router = new VueRouter({
    routes
})

Vue.component('login', Login)
Vue.component('home', Home)
Vue.component('register',RegisterUser)
Vue.component('profile', Profile)
Vue.component('myVirtualWallets', listVirtualWallets)
Vue.component('operator', Operator)
Vue.component('movements', Movements)

const store = new Vuex.Store({
    state: {
      token: "",
      user: null,
      loggedin: false,
      movements: null,
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
        },
        setMovements(state, movements){
            state.movements = movements
        }
    },
    getters: {
        token: state => state.token,
        loggedin: state => state.loggedin,
        user: state => state.user,
        movements: state => state.movements
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
            if(localStorage.getItem('user')!=null){
                this.$store.commit('setUser',JSON.parse(localStorage.getItem('user')));
                this.$store.commit('setMovements',JSON.parse(localStorage.getItem('movement')));
            }else{
            axios.get('/api/users/me')
                .then(response => {
                    this.$store.commit('setUser',response.data);
                    localStorage.setItem("user",JSON.stringify(response.data));
                });
            axios.get('/api/movements')
                .then(response => {
                    this.$store.commit('movements',response.data.data);
                    localStorage.setItem("movements",JSON.stringify(response.data.data));
                });
            }
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

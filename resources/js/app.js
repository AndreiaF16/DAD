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
//import listVirtualWallets from './components/wallets/wallets';
import Movements from './components/movements/movements';

import CreateUser from './components/admin/createUser';
import User from './components/admin/users';

import WalletComponent from './components/wallets/Wallet';
import Vuex from 'vuex';

import RegisterDebit from './components/users/RegisterDebit';


import Vue from 'vue'
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

import PaginationComponent from 'laravel-vue-pagination';
Vue.component('pagination', PaginationComponent);

Vue.use(Vuex);
Vue.use(VueRouter);
Vue.use(VueGoodTable);
Vue.use(VueSidebarMenu);

const routes = [
    {path:'/', redirect:'/home'},
    {path:'/home', component:Home},
    {path:'/login', component:Login, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")!=null){
            next("/home");
        }else{
            next();
        }}},
    {path:'/register', component:RegisterUser},
    {path: '/profile', component:Profile, beforeEnter: (to, from, next) => {
        if(localStorage.getItem("token")==null){
            next("/home");
        }else{
            next();
        }
    }},
    {path: '/myWallets', component:WalletComponent, beforeEnter: (to, from, next) => {
        var $userGet = JSON.parse(localStorage.getItem('user'));
        if(localStorage.getItem("token")==null){
            next("/");
        }else if($userGet.wallet == null){
            next("/");
        }else{
            next();
        }
    }},
    {path: '/operator', component:Operator, beforeEnter: (to, from, next) => {
        var $userGet = JSON.parse(localStorage.getItem('user'));
        if(localStorage.getItem("token")==null){
            next("/");
        }else if($userGet.type!="o"){
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
   {path:'/createUser', component:CreateUser},
   {path:'/users', component:User},
   {path:'/debit', component:RegisterDebit},

]

const router = new VueRouter({
    routes
})

Vue.component('login', Login)
Vue.component('home', Home)
Vue.component('register',RegisterUser)
Vue.component('profile', Profile)
//Vue.component('myWallets', listVirtualWallets)
Vue.component('operator', Operator)
Vue.component('movements', Movements)
Vue.component('myWallets', WalletComponent)
Vue.component('createUser', CreateUser)

Vue.component('users', User)


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
    },created(){
        const token = localStorage.getItem("token")
        if(token != null){
            this.$store.commit('setToken',token);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
            if(localStorage.getItem('user')!=null){
                this.$store.commit('setUser',JSON.parse(localStorage.getItem('user')));
            }else{
            axios.get('/api/users/me')
                .then(response => {
                    this.$store.commit('setUser',response.data);
                    localStorage.setItem("user",JSON.stringify(response.data));
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

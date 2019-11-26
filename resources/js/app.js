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
import RegisterUser from './components/registerUser.vue';

Vue.use(VueRouter);

const routes = [
    {path:'/', redirect:'/home'},
    {path:'/home', component:Home},
    {path:'/login', component:Login},
    {path:'/register', component:RegisterUser}
]

const router = new VueRouter({
    routes
})

Vue.component('login', Login)
Vue.component('home', Home)
Vue.component('register',RegisterUser)

const app = new Vue({
    el: '#app',
    router,
    data: {
    },
});

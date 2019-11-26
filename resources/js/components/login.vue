<template>
<div>
            <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message" @close="close"></show-message>

    <div class="jumbotron">
            <h1>User Login</h1>
        </div>

        <form>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" v-model.trim="user.email"
                       name="email" id="inputEmail"
                       placeholder="Email address" value="" />
            </div>
            <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" v-model="user.password"
                       name="password" id="inputPassword"
                       placeholder="Password" value="" />
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" v-on:click.prevent="userLogin()">Login</button>
                <button type="submit" class="btn btn-light" v-on:click.prevent="cancelLogin()">Cancel</button>
            </div>
        </form>
    </div>
</template>
<script type="text/javascript">

    import showMessage from './helpers/showMessage.vue';

    export default {
        data: function () {
            return {
                message: "",
                typeofmsg: "alert-success",
                showMessage: false,
                user: {
                    email:"",
                    password:"",
                    remember_token: null,
                },
            }
        },
        methods: {
            userLogin(){
                axios.post('/api/login', this.user)
                    .then(response => {
                        this.message = "User authenticated correctly";
                        this.showMessage = true;
                        this.user.remember_token = response.data.access_token;
                        this.$store.commit('setToken',this.user.remember_token);
                        this.$store.commit('logIn',true);
                        localStorage.setItem("token", this.user.remember_token);
                        axios.defaults.headers.common.Authorization = "Bearer " + this.user.remember_token;
                        axios.get('/api/users/me')
                            .then(response => {
                                 console.log(response.data);
                                this.$store.commit('setUser',response.data.data);
                             localStorage.setItem("user",JSON.stringify(response.data.data));
                                 this.message = "User authenticated correctly";
                            this.typeofmsg = "alert-success";
                            this.showMessage = true;
                            });
                        this.$router.push('/home');
                    })
                    .catch(error => {
                        console.log(error);
                        this.showMessage=true;
                        this.message = "Invalid credentials";
                       //this.message=error.response.data.unauthorized;
                        this.typeofmsg= "alert-danger";
                        return;


                    });
            },
             close(){
                this.showMessage = false;
            }
        },
            cancelLogin() {
                this.$router.push('/home');
            },
             components: {
            'show-message':showMessage,
        },

    };
</script>

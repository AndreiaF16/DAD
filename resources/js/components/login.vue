<template>
    <div class="jumbotron">

            <h2>User Login</h2>
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
                <a class="btn btn-primary" v-on:click.prevent="userLogin()">Login</a>
                <a class="btn btn-light" v-on:click.prevent="cancelLogin()">Cancel</a>
            </div>
        </div>


</template>
<script>
    export default {
        data: function () {
            return {
                user: {
                    email:"",
                    password:"",
                },
            }
        },
        methods: {
            userLogin(){
               // this.$emit('user-login', this.user);
               axios.post('api/login', this.user)
                .then(response => {

                  //  this.$store.
                 // this.$store.commit('setToken',response.data.remember_token);
                     return axios.get('api/home');
                 })
                 .then(response => {
                                   this.message = "User authenticated correctly";
                                    this.showMessage = true;
                                })
                                .catch(error => {
                                    this.showMessage = true;
                                    console.log(error);
                                });
            },
            cancelLogin() {
                this.$emit('cancel-login');
            }
        }
    }
</script>

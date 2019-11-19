<template>
    <div class="jumbotron">
        <form>
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
                <button type="submit" class="btn btn-primary" v-on:click.prevent="userLogin()">Login</button>
                <button type="submit" class="btn btn-light" v-on:click.prevent="cancelLogin()">Cancel</button>
            </div>
        </form>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                message: "",
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
<<<<<<< HEAD
               // this.$emit('user-login', this.user);
               axios.post('api/login', this.user)
                .then(response => {
                        console.log(response.data);
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
=======
                axios.post('/api/login', this.user)
                    .then(response => {
                        this.message = "User authenticated correctly";
                        this.showMessage = true;
                        this.user.remember_token = response.data.access_token;
                        this.$store.commit('setToken',this.user.remember_token);
                        this.$store.commit('logIn',true);
                        localStorage.setItem("token", this.user.remember_token);
                        axios.defaults.headers.common.Authorization = "Bearer " + this.user.remember_token;
                        this.$router.push('/home');
                    })
                    .catch(error => {
                        this.showMessage = true;
                        if(error.response){
                            console.log(error.response);
                        }
                        
                    });
>>>>>>> c76c6c142e34fc33fbb43e2ed0651499bf5ab343
            },
            cancelLogin() {
                this.$router.push('/home');
            }
        }
    }
</script>

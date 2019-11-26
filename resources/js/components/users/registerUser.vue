<template>


<div>
    <div class="container">
        <div class="jumbotron row justify-content-center">
                <h1>{{tittle}}</h1>
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
                <input type="name" class="form-control" v-model.trim="user.name"
                 name="name" id="inputName" placeholder="Enter name">
        </div>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" v-model="user.email"
          name="email" id="inputEmail" placeholder="Enter email address">

      </div>
      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
          type="password"
          class="form-control"
          v-model="user.password"
          name="password"
          id="inputPassword"
          placeholder="Enter password"
        >

      </div>
      <!--<div class="form-group">

                <file-upload v-on:fileChanged="onFileChanged">
                  <a class="btn btn-primary" v-on:click.prevent="submitFile">Submit Photo</a>
                </file-upload>

            </div>-->
      <div class="form-group">
        <label for="inputNif">Nif</label>
        <input
          type="text"
          class="form-control"
          v-model="user.nif"
          name="nif"
          id="inputNif"
          placeholder="Enter nif"
        >

      </div>

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="register">Register</a>

                    <a class="btn btn-danger" v-on:click.prevent="cancelEdit">Cancel</a>
      </div>
    </div>
  </div>

</template>

<script type="text/javascript">
//import fileUpload from './helpers/uploadFile';

//module.exports = {
export default {
  data: function() {
    return {
        tittle:'Regist User',
      user: {
        name: "",
        email: "",
        password: "",
        photo: "",
        nif: "",
      }
    };
  },
  methods: {
    register() {
      axios
        .post("api/registerUser", this.user)
        .then(response => {
          console.log("response", response);

        })
        .catch(error => {
          console.log(error);
          let data = error.response.data.errors;
          for (let key in this.errors) {
            this.errors[key] = [];
            let errorMessage = data[key];
            if (errorMessage) {
              this.errors[key] = errorMessage;
            }
          }
        });
    },cancelEdit() {
            this.$router.push('/home' );
        },
    /*onFileChanged(fileSelected) {
                this.file = fileSelected
            }, submitFile(){
            let formData = new FormData();
            // Add the form data we need to submit
            formData.append('file', this.file);
            axios.post('/api/users/updatePhoto/' + this.user.id, formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            ).then(response =>{
                this.$store.commit('setUser',response.data.data);

            })
            .catch(function(){
            console.log('FAILURE!!');
            });
        },*/
  },
  components: {
            //'error-validation':errorValidation,
            //'show-message':showMessage,
         //   'file-upload': fileUpload,
        },
};
</script>

<style>
</style>

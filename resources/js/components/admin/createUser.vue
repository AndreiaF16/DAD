<template>
    <div >
        <div class="jumbotron row justify-content-center">
            <h1>{{title}}</h1>
        </div>

        <div class="alert alert-danger" v-if="showError">
			<button type="button" class="close-btn" v-on:click="showError=false">&times;</button>
			<strong>{{ successMessage }}</strong>
		</div>

        <div class="accountCreate-form">
            <div class="form-group">
                <label for="inputName">Name: </label>
                <input type="text" class="form-control" id="inputName" v-model="user.name" placeholder="Name" required>
            </div>

            <div class="form-group">
                <label for="inputEmail">Email: </label>
                <input type="email" class="form-control" id="inputEmail" v-model="user.email" placeholder="Email" required>
            </div>

            <div class="form-group">
            <label for="type">Type:</label>
                <select name="type" id="type" class="form-control" v-model="user.type" required>
                   <option value='' selected> -- Select the Type Of User -- </option>
                    <option value="a">Administrator</option>
                    <option value="o">Operator</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputPassword">Password: </label>
                <input type="password" class="form-control" id="inputPassword" v-model="user.password" placeholder="Password" required>
            </div>

             <div class="form-group">
            <file-upload v-on:fileChanged="onFileChanged"> </file-upload>
        </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="register()">Save</a>
                <a class="btn btn-danger" v-on:click.prevent="cancelCreate()">Cancel</a>
            </div>
        </div>
    </div>
</template>

<script>
 import fileUpload from '../helpers/uploadFile.vue';

    export default {
        data: function () {
            return {
                title: 'Create Administator or Operator',
               user: {
                    name: '',
                    type: '',
                    email: '',
                    photo: '',
                },
                showError: false,
                successMessage: '',
            }
        },
        methods: {
             register() {
      let formdata = new FormData();
            formdata.append('name', this.user.name);
            formdata.append('nif', this.user.nif);
            formdata.append('email',this.user.email);
            formdata.append('type',this.user.type);
          formdata.append('password',this.user.password);
            formdata.append('photo', this.user.photo);
            formdata.append('_method', 'POST');
      axios
        .post("api/createUser", formdata)
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
    },
          /*  createUserAdmin: function() {
                axios.post('api/createUser', this.user)
                .then(response => {
                    console.log(response);
                    this.$emit('admin-created');
                })
                .catch(error => {
                    console.error(error);
                    if(error.response.data.errors.name){
                        this.successMessage = error.response.data.errors.name[0];
                        this.showError = true;
                    }else if(error.response.data.errors.email){
                        this.successMessage = error.response.data.errors.email[0];
                        this.showError = true;
                    }
                    else if(error.response.data.errors.password){
                        this.successMessage = error.response.data.errors.password[0];
                        this.showError = true;
                    }
                    else if(error.response.data.errors.type){
                        this.successMessage = error.response.data.errors.type[0];
                        this.showError = true;
                    }else if (error.response.data.errors.photo){
                        this.successMessage = error.response.data.errors.photo[0];
                        this.showError = true;
                    }
                });
            },*/
            cancelCreate: function(){
                this.$emit('create-canceled');
            },
            onFileChanged(fileSelected) {
                this.user.photo = fileSelected
            },
        },
         components: {
            //'error-validation':errorValidation,
            //'show-message':showMessage,
            'file-upload': fileUpload,
        },
    }
</script>

<style scoped>
</style>

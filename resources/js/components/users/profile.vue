<template>
<div class="content">
        <div class="jumbotron">
            <h1>Profile</h1>
          </div>

          <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message" @close="close"></show-message>

        <error-validation :showErrors="showErrors" :errors="errors" @close="close"></error-validation>

          <div>

          <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" v-model="user.name"
                       name="name" id="inputName"
                       placeholder="Fullname" value="" />
            </div>

             <div class="form-group">
                <label for="inputNif">Nif</label>
                <input type="number" class="form-control" v-model="user.nif"
                       name="nif" id="inputNif"
                       placeholder="Nif" value="" />
            </div>

             <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="user.email"
                    name="email" id="inputEmail"
                    placeholder="Email address" readonly/>
            </div>

             <div class="form-group">

                <file-upload v-on:fileChanged="onFileChanged"> </file-upload>
             <!--   <img  width="100px"  :src="'storage/' + user.photo" >-->
              <!--  <img  width="100px"  :src="'storage/images/profiles/' + user.photo_url" >-->
                <br>
            </div>

             <div class="form-group">
                    <a class="btn btn-primary" v-on:click.prevent="savedUser">Save Changes</a>
                    <a class="btn btn-danger" v-on:click.prevent="cancelEdit">Cancel</a>
            </div>

<div>
			<h5>Change Password</h5>

			<div class="form-group">
				<label for="oldPassword" class="col-sm-4 col-form-label">Current Password</label>
				<div class="col-sm-10">
					<input type="password" name="password_old" class="form-control" id="password_old" v-model="password_old" placeholder="Insert your current password"/>
				</div>
			</div>

			<div class="form-group">
				<label for="newPassword" class="col-sm-4 col-form-label"> New Password</label>
				<div class="col-sm-10">
					<input type="password" name="password" class="form-control" v-model="password" id="password" placeholder="New Password">
				</div>
			</div>

			<div class="form-group">
				<label for="passwordConfirmation" class="col-sm-4 col-form-label"> Password Confirmation</label>
				<div class="col-sm-10">
					<input type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" id="passwordConfirmation" placeholder="Confirm your new password" >
				</div>
			</div>
            </div>

 <div class="form-group">
                    <a class="btn btn-primary" v-on:click.prevent="savedPassword">Save Password</a>
                    <a class="btn btn-danger" v-on:click.prevent="cancelEdit">Cancel</a>
            </div>


        </div>


</div>
</template>
<script type="text/javascript">
  import errorValidation from '../helpers/showErrors.vue';
    import showMessage from '../helpers/showMessage.vue';
  import fileUpload from '../helpers/uploadFile.vue';

export default {

    data: function() {
      return {
            errors: [],
            showMessage: false,
            showErrors: false,
            typeofmsg: "",
            message:'',
            file: '',
            user: [],
            file: '',
            password_old:'',
             message:'',
			password:'',
            password_confirmation:'',
      }
    },

    methods: {
        onFileChanged(fileSelected) {
                this.file = fileSelected
            },
        clear () {
            this.name = ''
          //  this.username = ''
        },
        cancelEdit() {
            this.$router.push('/home' );
        },
        savedPassword(){

            axios.patch('/api/users/password',
				{
					'password_old':this.password_old,
					'password_confirmation':this.password_confirmation,
                    'password':this.password,


                }).then(response=>{
					this.showErrors=false;
					this.showMessage=true;
					this.message='Password updated with success';
					this.typeofmsg= "alert-success";
					this.$router.push('home' );
				}).catch(error=>{
					if(error.response.status==401){
						this.showMessage=true;
						this.message=error.response.data.unauthorized;
						this.typeofmsg= "alert-danger";
						return;
					}
					if(error.response.status==422){
						if(error.response.data.errors==undefined){
							this.showErrors=false;
							this.showMessage=true;
							this.message=error.response.data.password_old;
							this.typeofmsg= "alert-danger";
						}else{
							this.showMessage=false;
							this.showErrors=true;
							this.errors=error.response.data.errors;
						}
					}
				});
        },
        savedUser(){
             this.showMessage=false;
                this.showErrors=false;
            axios.put('/api/users/updateProfile/', this.user)
                .then(response => {
                    this.showErrors=false;
                    this.showMessage=true;
                    this.message='Profile updated with success';
                    this.typeofmsg= "alert-success";

                     this.$store.commit('setUser',response.data);
                     localStorage.setItem("user",JSON.stringify(response.data));
                })
            .catch(error=>{
                    if(error.response.status==401){
                        this.showMessage=true;
                        this.message=error.response.data.unauthorized;
                        this.typeofmsg= "alert-danger";
                        return;
                    }

                    if(error.response.status==422){
                        if(error.response.data.errors==undefined){
                            this.showErrors=false;
                            this.showMessage=true;
                            this.message=error.response.data.user_already_exists;
                            this.typeofmsg= "alert-danger";
                        }else{
                            this.showMessage=false;
                            this.showErrors=true;
                            this.errors=error.response.data.errors;
                        }
                    }
                });


           // localStorage.setItem("user",JSON.stringify(this.user));
        },  close(){
                this.showErrors=false;
                this.showMessage=false;
            },


    //  submitFile(){
//let formData = new FormData();
            //criar link strorage para as fts
            // Add the form data we need to submit
          /*  formData.append('file', this.file);
            axios.post('/api/user/updatePhoto/' + this.user.id, formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            .then(response =>{
                this.$store.commit('setUser',response.data);

            })
            .catch(function(){
            console.log('FAILURE!!');
            });*/
       // },
      /*  handleFileUpload(){
            this.file = this.$refs.file.files[0];
        }*/
    },
    mounted() {
      // this.getUserInfor();
        this.user = JSON.parse(localStorage.getItem('user'));;
      // this.getInformationFromLoggedUser();

    },
     components: {
            'error-validation':errorValidation,
            'show-message':showMessage,
            'file-upload': fileUpload,
        },
}
</script>

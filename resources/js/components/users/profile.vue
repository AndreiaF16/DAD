<template>
<div class="content">
        <div class="jumbotron">
            <h1>Profile</h1>
          </div>
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

<!--
<div class="form-group">

                <input type="file" id="file" ref="file"  v-on:change="handleFileUpload()"/>

               <img  width="100px"  :src="'storage/profiles/' + user.photo_url" >
                <img  width="100px"  :src="'storage/images/profiles/' + user.photo_url" >
                <a class="btn btn-primary" v-on:click.prevent="submitFile">Submit Photo</a>
            </div>

-->
            <div class="form-group">
                    <a class="btn btn-primary" v-on:click.prevent="savedUser">Save</a>
                    <a class="btn btn-danger" v-on:click.prevent="cancelEdit">Cancel</a>
            </div>
        </div>


</div>
</template>
<script>
export default {

    data: function() {
      return {
            user: [],
            file: '',
            password_old:'',
			password:'',
			password_confirmation:'',
      }
    },

    methods: {
        clear () {
            this.name = ''
          //  this.username = ''
        },
        savedUser(){
<<<<<<< HEAD
            axios.put('/api/users/updateProfile/' + this.user.id, this.user)
=======
            axios.put('/api/users/updateProfile', this.user)
>>>>>>> cafdcd282966970627aa6d04660c766c67ccbea6
                .then(response => {
                     this.$store.commit('setUser',response.data.data);
                     localStorage.setItem("user",JSON.stringify(response.data.data));
                })
          /*  axios.put('/api/user/updateProfile/' + this.user.id, this.user).then(response => {
                this.$store.commit('setUser',response.data);
            })*/
            .catch(function(err) {
                console.log(err);
            });
           // localStorage.setItem("user",JSON.stringify(this.user));
        }, cancelEdit() {
                this.$emit('cancel-edit');
            }

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
}
</script>

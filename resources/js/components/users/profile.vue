<template>

<div>
        <div class="jumbotron">
            <h1>Profile</h1>
          </div>
          <div>
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input
                    type="text" class="form-control" v-model="user.username"
                    name="username" id="inputUsername"
                    placeholder="Username"/>
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                    type="text" class="form-control" v-model="user.name"
                    name="name" id="inputName"
                    placeholder="Fullname"/>
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                    type="email" class="form-control" v-model="user.email"
                    name="email" id="inputEmail"
                    placeholder="Email address" readonly/>
            </div>

            <div class="form-group">

                <input type="file" id="file" ref="file"  v-on:change="handleFileUpload()"/>
                <!---->
                <img  width="100px"  :src="'storage/profiles/' + user.photo_url" >
                <img  width="100px"  :src="'storage/images/profiles/' + user.photo_url" >
                <a class="btn btn-primary" v-on:click.prevent="submitFile">Submit Photo</a>
            </div>


            <div class="form-group">
                    <a class="btn btn-primary" v-on:click.prevent="savedUser">Save</a>
                    <a class="btn btn-danger" v-on:click.prevent="cancelEdit">Cancel</a>
            </div>
        </div>


</div>
</template>
<script>
export default {
    data () {
      return {
            user: [],
            file: ''
      }
    },

    methods: {
        clear () {
            this.name = ''
            this.username = ''
        },
        savedUser(){
            axios.put('/api/user/updateProfile/' + this.user.id, this.user).then(response => {
                this.$store.commit('setUser',response.data.data);
            })
            .catch(function(err) {
                console.log(err);
            });
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        submitFile(){
            let formData = new FormData();
            // Add the form data we need to submit
            formData.append('file', this.file);
            axios.post('/api/user/updatePhoto/' + this.user.id, formData,
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
        },
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        }
    },
    mounted() {
       this.getUserInfor();
      // this.getInformationFromLoggedUser();
    },
}
</script>

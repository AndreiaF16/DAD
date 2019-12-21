<template>


<div>
    <div class="container">
      <h2>Create an Income</h2>

      </div>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control"  v-model="movement.email"  name="email"
          id="inputEmail" placeholder="Enter email address">
      </div>

      <div class="form-group">
        <label for="inputValue">Value</label>
        <input type="text" class="form-control" v-model="movement.value"  name="value" id="inputValue"
        placeholder="Enter value">
      </div>
    <div class="form-group">
        <label for="inputPaymentType">Payment Type</label>
        <select class="btn btn-xs btn-primary dropdown-toggle btn-block" name="PaymentType" id="PaymentType" v-model="movement.type_payment" required>
            <option disabled selected> -- select an option -- </option>
            <option value="c">Cash</option>
            <option value="bt">Bank Transfer</option>
            <option value="mb">MB payment</option>
        </select>
    </div>
    <div v-if="this.movement.type_payment == 'bt'" >

      <div class="form-group">
        <label for="inputSrc_Desc">Source Description</label>
        <textarea type="text" class="form-control" v-model="movement.source_description" name="Src_Desc" id="inputSrc_Desc"
          placeholder="Enter the Source Description">
        </textarea>
      </div>

        <div class="form-group">
            <label for="inputIBAN">IBAN</label>
            <input type="text" class="form-control" v-model="movement.iban" name="IBAN" id="inputIBAN"
            placeholder="Enter IBAN">
        </div>
</div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="registerIncome">Create Income</a>
        </div>

</div>
</template>

<script>

  import errorValidation from '../helpers/showErrors.vue';
  import showMessage from '../helpers/showMessage.vue';

  export default{
  data: function() {
    return {
      errors: [],
      showMessage: false,
      showErrors: false,
      message:"",
      movement: {
        email: "",
        value: "",
        type_payment: "",
        iban: "",
        source_description: "",
      },
      notificationMsg: ""
    };
  },
  methods: {
    registerIncome() {
      axios.post("api/operator/registerIncome",this.movement)
      .then(response=>{
					this.showErrors=false;
					this.showMessage=true;
					this.message='Income registered with success';
          this.typeofmsg= "alert-success";
          let msg = "A new income of "+ this.movement.value + " is added to your account";
          this.$socket.emit("notifyMovement",msg,{ email:response.data.email, id: response.data.id})
          this.$toasted.success("Income created!");
					this.$router.push('/home');
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
							this.message=error.response.data.email;
							this.typeofmsg= "alert-danger";
						}else{
							this.showMessage=false;
							this.showErrors=true;
							this.errors=error.response.data.errors;
						}
					}
				});
    }
  },
    sockets:{
      notifyMovement: function(msg){
        this.notificationMsg = msg;
      }
    },
  components: {
    'error-validation':errorValidation,
    'show-message':showMessage,
  },
};
</script>

<style>
</style>

<template>


<div>
    <div class="container">
      <h2>Create an Income</h2>

      </div>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model="user.email"
          name="email"
          id="inputEmail"
          placeholder="Enter email address"
        >

      </div>
      <div class="form-group">
        <label for="inputValue">Value</label>
        <input
          type="text"
          class="form-control"
          v-model="user.password"
          name="value"
          id="inputValue"
          placeholder="Enter value"
        >
      </div>
    <div class="form-group">
        <label for="inputPaymentType">Payment Type</label>
        <select class="btn btn-xs btn-primary dropdown-toggle btn-block"  name="PaymentType">
            <option value="c">Cash</option>
            <option value="bt">Bank Transfer</option>
            <option value="mb">MB payment</option>
        </select>
    </div>
      <div class="form-group">
        <label for="inputSrc_Desc">Source Description</label>
        <textarea
          type="text"
          class="form-control"
          v-model="user.nif"
          name="Src_Desc"
          id="inputSrc_Desc"
          placeholder="Enter the Source Description"
        ></textarea>
      </div>

      <div class="form-group">
        <label for="inputIBAN">IBAN</label>
        <input
          type="text"
          class="form-control"
          v-model="user.password"
          name="IBAN"
          id="inputIBAN"
          placeholder="Enter IBAN"
        >
      </div>

      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="register">Create Income</a>
      </div>
    </div>
</template>

<script>
//import fileUpload from './helpers/uploadFile';

//module.exports = {
  export default{
  data: function() {
    return {
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
    }
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

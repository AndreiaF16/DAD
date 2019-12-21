<template>
    <div class="jumbotron">
        <h2>Register Debit</h2>


    <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message" @close="close"></show-message>

    <error-validation :showErrors="showErrors" :errors="errors" @close="close"></error-validation>

        <div class="form-group">
            <label for="inputEmail">Email To Debit:</label>
            <input
                type="email" class="form-control" v-model="email"
                name="email" id="inputEmail"
                placeholder="Insert email of the account to receive the money" required
                title="Email must be a valid user email"/>
        </div>

        <div class="form-group">
            <label for="inputValue">Value To Debit:</label>
            <input
                type="text" class="form-control" v-model="value"
                name="value" id="inputValue"
                placeholder="Insert value to credit" required
                title="Value needs to be between 0.1 and 5000"/>
        </div>

        <div class="form-group">
            <label for="type_payment">Type Of Payment:</label>
            <select name="type_payment" id="type_payment" class="form-control" v-model="type_payment" required>
                <option disabled selected> -- select an option -- </option>
                <option value="c">Cash</option>
                <option value="bt">Bank Transfer</option>
                <option value="mb">MB Payment</option>
            </select>
        </div>

        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control" v-model="category_id" required>
                <option disabled selected> -- select an option -- </option>
                <option v-for="paymentType in paymentTypes" :key="paymentType.id" v-bind:value="paymentType.id">{{ paymentType.name }}</option>
            </select>
        </div>

        <div v-if="this.type_payment == 'bt'" >
            <div class="form-group">
                <label for="inputIBAN">IBAN:</label>
                <input
                    type="text" class="form-control" v-model="iban"
                    name="iban" id="inputIBAN"
                    placeholder="Insert IBAN" required
                    title="INAN must be 2 upper letters followed by 23 numbers"/>
            </div>
        </div>

        <div v-if="this.type_payment == 'mb'" >
            <div class="form-group">
                <label for="inputEntity">Entity:</label>
                <input
                    type="number" class="form-control" v-model="mb_entity_code"
                    name="entity" id="inputEntity"
                    placeholder="Insert Entity" required/>
            </div>

            <div class="form-group">
                <label for="inputReference">Reference:</label>
                <input
                    type="number" class="form-control" v-model="mb_payment_reference"
                    name="reference" id="inputReference"
                    placeholder="Insert Reference" required/>
            </div>

            <div class="form-group">
                <label for="inputDescription">Description:</label>
                <input
                    type="text" class="form-control" v-model="description"
                    name="description" id="inputDescription"
                    placeholder="Insert a description" required/>
            </div>
        </div>

        <div class="form-group">
            <label for="inputTransfer">Transfer:</label>
            <select name="transfer" id="transfer" class="form-control" v-model="transfer" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div v-if="this.transfer == '1'">
            <div class="form-group">
                <label for="inputSourceEmail">Destination wallet email</label>
                <input
                    type="email" class="form-control" v-model="destination_email"
                    name="destination_email" id="inputDestinationEmail"
                    placeholder="Destination wallet email address"/>
            </div>
            <div class="form-group">
                <label for="inputSourceDescription">Source Description:</label>
                <input
                    type="text" class="form-control" v-model="source_description"
                    name="source_description" id="inputSourceDescription"
                    placeholder="Insert a source description" required/>
            </div>
        </div>

        <div class="form-group">
            <a class="btn btn-success" v-on:click.prevent="createCredit()">Create Credit</a>
            <a class="btn btn-danger" v-on:click.prevent="cancelDebit()">Cancel</a>
        </div>

    </div>
</template>

<script type="text/javascript">
  import errorValidation from '../helpers/showErrors.vue';
    import showMessage from '../helpers/showMessage.vue';

   export default {
           data: function() {
            return {
                name: "RegisterDebit",
                typeofmsg: '',
                message:'',
                showErrors: false,
                showMessage: false,
                errors: [],
                email: '',
                type_payment: '',
                value: '',
                category_id: '',
                iban: '',
                source_description: '',
                mb_entity_code: '',
                description: '',
                mb_payment_reference: '',
                destination_email: '',
                transfer: 0,
                paymentTypes: []
            }
      },
    methods: {
        createCredit(){
            let formdata = new FormData();
            formdata.append('email', this.email);
            formdata.append('type_payment', this.type_payment);
            formdata.append('value', this.value);
            formdata.append('iban', this.iban);
            formdata.append('source_description', this.source_description);
            formdata.append('description', this.description);
            formdata.append('mb_payment_reference', this.mb_payment_reference);
            formdata.append('destination_email', this.destination_email);
            formdata.append('transfer', this.transfer);
            formdata.append('_method', 'POST');
            axios.post('/api/movements/debit',formdata)
            .then(response => {
                this.paymentTypes = response.data.data;
            });
        },
        cancelDebit(){
            this.$emit('cancel-debit');
        },
        close(){
                this.showErrors=false;
                this.showMessage=false;
            },
    },mounted(){
        axios.get('/api/categories/expense')
        .then(response => {
            this.paymentTypes = response.data.data;
        });
    },
    components: {
        'error-validation':errorValidation,
        'show-message':showMessage,
    },

   }
</script>

<style scoped>
</style>

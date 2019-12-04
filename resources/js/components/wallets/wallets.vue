<template>

        <div>
            <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message"
            			@on-column-filter="onColumnFilter"

             @close="close"></show-message>
            <div class="jumbotron row justify-content-center">
                <h1>{{tittle}}</h1>
        </div>
            <div class="form-group">
                <label for="inputBalance">Balance of My Virtual Wallet</label>
                <input type="text" class="form-control"
                        name="balance" id="inputBalance"
                        placeholder="Balance" v-model="wallet.balance" readonly/>
            </div>

            <vue-good-table styleClass="vgt-table striped" :columns="columns" :rows="movements"
            :pagination-options="{ enabled: true, mode: 'records', perPage : 15}"
            :search-options="{ enabled: true}"
            @on-row-click="onRowClick" :row-style-class="rowStyleFn"
            @click="getMovements()"
              theme="white-rhino"
               >


                <template slot="table-row" slot-scope="props">


                 </template>
            </vue-good-table>
            <!--<button @click="getMovements()"></button>-->
        </div>
</template>

<script type="text/javascript">
    /*jshint esversion: 6 */
    import showMessage from '../helpers/showMessage.vue';

    export default {

        data:
            function() {
                return {
                    tittle: "My Virtual Wallet",
                    user: {},
                    wallet: {},
                    movements: [],
                    showMessage:false,
                    message:'',
                    typeofmsg: "",
                    current_page: 1,
                    rows: [],
                   // totalRecords: 0,
                    columns: [
                        {
                            label: "Id",
                            field: 'id',

                            filterOptions: {
                                enabled: true,
                                placeholder: 'Enter an Id',
                            },
                        },
                        {
                            label: "Email",
                            field: 'email',
                              filterOptions: {
                                enabled: true,
                                placeholder: 'Enter an Email',
                            },
                        },
                        {
                            label: "Type of Movement",
                            field: 'type',

                            filterOptions: {
                                enabled: true,
                                filterDropdownItems: [
                                    { value: 'i', text: 'income' },
                                    { value: 'e', text: 'expensive' },
                                ],

                            },
                        },
                        {
                            label: "Type of Payment",
                            field: 'type_payment',
                            filterOptions: {
                                enabled: true,
                                filterDropdownItems: [
                                    { value: 'c', text: 'Cash' },
                                    { value: 'bt', text: 'Bank Transfer' },
                                    { value: 'mb', text: 'MB payment' },

                                ],

                            },
                        },
                        {
                            label: "Categoty",
                            field: 'category',
                            filterOptions: {
                                enabled: true,
                                filterDropdownItems: [
                                    { value: '1', text: 'groceries' },
                                    { value: '2', text: 'restaurant' },
                                    { value: '3', text: 'clothes' },
                                    { value: '4', text: 'shoes' },
                                    { value: '5', text: 'school' },
                                    { value: '6', text: 'services' },
                                    { value: '7', text: 'electricity' },
                                    { value: '8', text: 'phone' },
                                    { value: '9', text: 'fuel' },
                                    { value: '10', text: 'mortgage payment' },
                                    { value: '11', text: 'car payment' },
                                    { value: '12', text: 'entertainment' },
                                    { value: '13', text: 'gadget' },
                                    { value: '14', text: 'computer' },
                                    { value: '15', text: 'vacation' },
                                    { value: '16', text: 'hobby' },
                                    { value: '17', text: 'loan repayment' },
                                    { value: '18', text: 'loan' },
                                    { value: '19', text: 'other expense' },
                                    { value: '20', text: 'salary' },
                                    { value: '21', text: 'bonus' },
                                    { value: '22', text: 'royalties' },
                                    { value: '23', text: 'interests' },
                                    { value: '24', text: 'gifts' },
                                    { value: '25', text: 'dividends' },
                                    { value: '26', text: 'sales' },
                                    { value: '27', text: 'loan repayment' },
                                    { value: '28', text: 'loan' },
                                    { value: '29', text: 'other income' },

                                ],

                            },
                        },
                        {
                            label: "Date",
                            field: 'date',
                            type:'date',
                            dateInputFormat: 'y-MM-dd HH:mm:ss',
                            dateOutputFormat: 'dd/MM/yyyy HH:mm:ss',
                            filterOptions: {
                                enabled: true,
                                placeholder: 'Enter a date',
                            },
                          //  type: 'date',
                            // dateInputFormat: 'YYYY-MM-DD HH:mm:ss',
                            //dateOutputFormat: 'DD/MM/YYYY HH:mm:ss',
                           // filterOptions: {
                             //   enabled: true,
                              //  placeholder: 'Enter a date',
                           // },

                        },

                    ],
                };
            },
        methods:{
            close(){
            },
            getMovements(){
                axios.get('api/users/wallet/movements')//?page='+(this.current_page+=1))
                .then(response => {
                    this.movements = response.data.data;
                })
                .catch(error => {
                    console.log(error.response)
                });
            },
             onRowClick(params){
                if(this.showSelected == true)
                {
                    this.selectedRow = params.row.originalIndex;
                    this.$emit('selectedRow',this.selectedRow);
                }
            },rowStyleFn(row) {

                return this.selectedRow === row.originalIndex  && this.showSelected == true?'selectedRow':'';
            },
            onColumnFilter(params) {
				this.updateParams(params);
				this.getMovements();
			},

        },
        mounted(){
            this.user = JSON.parse(localStorage.getItem('user'));
            this.wallet = this.user.wallet;
            //this.movements = JSON.parse(localStorage.getItem('movements'))
            this.getMovements();
        },
        components: {
            'show-message':showMessage,
        },
    };
</script>

<style >
    .conf{
    font-weight: bold;
    background: #123456  !important;
    color: #fff          !important;
    padding: 0px 5px;
}
.selectedRow{
    background-color: darkgrey;
}
</style>




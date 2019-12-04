<template>

        <div>
            <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message" @close="close"></show-message>

            <div class="row justify-content-right">
                <h5>{{tittle}}</h5>
            </div>

            <div class="form-group">
                <label for="inputBalance">Balance of My Virtual Wallet</label>
                <input type="text" class="form-control" 
                        name="balance" id="inputBalance"
                        placeholder="Balance" v-model="wallet.balance"/>
            </div>
        
            <vue-good-table styleClass="vgt-table" :columns="columns" :rows="movements"
            :pagination-options="{ enabled: true, mode: 'records', perPage : 15}" @click="getMovements()">
            
                <!--<template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field=='actions'">
                    </span>
                    <span v-else>
                        {{props.formattedRow[props.column.field]}}
                    </span>
                </template>-->
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
                        },
                        {
                            label: "Email",
                            field: 'email',
                        },
                        {
                            label: "Type of Movement",
                            field: 'type',
                        },
                        {
                            label: "Type of Payment",
                            field: 'type_payment',
                        },
                        {
                            label: "Categoty",
                            field: 'name',
                        },
                        {
                            label: "Date",
                            field: 'date',
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
            }
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
<!--
//us 9
<style >
    .selectedRow{
        background-color: darkgrey;
    }
</style>-->




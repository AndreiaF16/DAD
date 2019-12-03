<template>

    <div>

            <show-message :class="typeofmsg" :showSuccess="showMessage" :successMessage="message" @close="close"></show-message>

            <vue-good-table ref="table" mode="remote"  :columns="columns" :rows="rows"
            :pagination-options="{ enabled: true}" >

                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field=='actions'">
                    </span>
                    <span v-else>
                        {{props.formattedRow[props.column.field]}}
                    </span>
                </template>
            </vue-good-table>
    </div>

</template>

<script type="text/javascript">
    /*jshint esversion: 6 */
    import showMessage from '../helpers/showMessage.vue';

    export default {
        props: ['myWallets'],
        data:
            function() {
                return {

                    showMessage:false,
                    message:'',
                    typeofmsg: "",
                  selectedRow: null,
                    rows: [],//Array.from(this.myWallets),
                   // totalRecords: 0,

                    columns: [
                        {
                            label: "Id",
                            field: 'id',
                        }, {
                            label: "email",
                            field: 'email',
                        },

                    ],
                };
            },
        methods:{
            getWallets: function() {
                axios.get('api/users/myVirtualWallets')
                .then(response=>{
					this.wallets = response.data.data;
					console.log(this.wallets);
				});
			},
            close(){
            }
        },
        mounted(){
            			this.getWallets(this.wallets);

           // console.log(this.myWallets);
            this.rows = Array.from(this.myWallets);
            console.log(this.rows);
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




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
                    rows: [],
                   // totalRecords: 0,

                    columns: [
                        {
                            label: "Id",
                            field: 'id',
                        }, {
                            label: "Type",
                            field: 'type',
                        },
                        {
                            label: 'email',
                            field: 'email',
                        }, {
                            label: 'Type Of Payment',
                            field: 'type_payment',
                        }, {
                            label: 'Category',
                            field: 'category_id',
                        }, {
                            label: 'Date',
                            field: 'date',

                        },
                        {
                            label: 'Start Balance',
                            field: 'start_balance',

                        },
                        {
                            label: 'End Balance',
                            field: 'end_balance',

                        },  {
                            label: 'Value',
                            field: 'value',

                        }, {
                            label: 'Actions',
                            field: 'actions',
                            sortable: false,
                        }
                    ],
                };
            },
        methods:{

            load() {
                axios.get('api/users/myVirtualWallets')
            .then(response=>{
                this.myWallets = response.data;
            });

            },
            close(){
            }
        },
        mounted(){

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


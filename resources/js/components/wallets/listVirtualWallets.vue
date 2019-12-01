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
                            label: "email",
                            field: 'email',
                        },

                    ],
                };
            },
        methods:{

           /* getWallets() {
                axios.get('api/users/myVirtualWallets')
            .then(response=>{
                this.myWallets = response.data;
            });

            },*/
            close(){
            }
        },
        mounted(){
           // this.getWallets();
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


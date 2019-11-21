<template>
<div class="content">
    <div class="title m-b-md">
        <h2> {{title}}</h2>
    <h2> {{text}}</h2>

        <h2> {{wallets}}</h2>

    </div>
</div>


</template>
<script>
    export default {
        data: function(){
        return{
            title: 'Welcome to Virtual Wallet ',
            text:'total number of virtual wallets: ',
            wallets: undefined
        }
    },
    mounted(){
        axios.get('api/home')
        .then(response=>{
            this.wallets = response.data;
        });
    }
}
</script>

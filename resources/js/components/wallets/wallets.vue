<template>
	<div>
		<div class="jumbotron">
            <h1>Tittle</h1>
        </div>
		<wallets-list :my_wallets="wallets" :showSelected="false"> </wallets-list>
	</div>
</template>

<script>
	/*jshint esversion: 6 */
	import walletsList from './listVirtualWallets.vue';
	export default {
		data:
			function() {
				return {
					wallets: []
				};
			},
		methods: {
			getWallets: function() {
                axios.get('api/users/myVirtualWallets')
                .then(response=>{this.wallets = response.data.data;});
			}
		},
		mounted() {
			this.getWallets();
		},
		components: {
            'wallets-list':walletsList,
			//myWallets
		},
	};
</script>

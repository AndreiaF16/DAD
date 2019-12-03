<template>
	<div>
		<div class="jumbotron">
            <h1>Tittle</h1>
        </div>
		<wallets-list :my-wallets="wallets" :showSelected="false"> </wallets-list>
	</div>
</template>

<script>
	/*jshint esversion: 6 */
	import walletsList from './listVirtualWallets.vue';
	export default {
		data:
			function() {
				return {
					wallets: {}
				};
			},
		methods: {
			getWallets: function() {
                axios.get('api/users/myVirtualWallets')
                .then(response=>{
					this.wallets = response.data.data;
					console.log(this.wallets);
				});
			}
		},
		mounted() {
			this.getWallets(this.wallets);
		},
		components: {
            'wallets-list':walletsList,
		},
	};
</script>

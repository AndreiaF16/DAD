<template>
	<div>
		<div class="jumbotron">
            <h1>Tittle</h1>
        </div>
		<wallets-list :wallets="wallets" :showSelected="false"> </wallets-list>
	</div>
</template>

<script>
	/*jshint esversion: 6 */

	import myWallets from './listVirtualWallets.vue';

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

                .then(response=>{this.items = response.data;});
			}
		},
		mounted() {
			this.load();
		},
		components: {
			getWallets
		},
	};

</script>

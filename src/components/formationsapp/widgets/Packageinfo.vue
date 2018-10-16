<template>
	<div class="col widget-column package-widget-column p-4">
		<div :class="{'send-to-back fadeOut': !loading, 'fadeIn': loading}" class="d-flex lds-dual-ring loading-app-div d-none h-100 w-100 justify-content-center align-items-center animated-fast"></div>
		<h5 class="p-2 text-light">My package</h5>
		<div class="row" v-if="!loading">
			<div class="col col-sm-3" v-for="(val, key, i) in packagedata.data" :key="key">
				{{val}}
			</div>
		</div>
	</div>
</template>
<script>
import {globalMixin} from './../../../mixins/globalmixin.js'

export default {
	mixins: [globalMixin],
	data(){
		return{
			loading: true,
			packagedata: '',
			keysToShow: ["formation_variations_per_team", "fixtures_count", "package_name", "paid_package", "package_type_cost", "players_per_team", "team_limit"]
		}
	},
	methods:{
		getPackageData(){
			let keys = this.keysToShow,
				allPackageData = JSON.parse(JSON.stringify(this.$store.getters.returnPackageInfo)); 
				
			for (const key in allPackageData.data) {
				
				if (object.hasOwnProperty(key)) {
					const element = object[key];
					
				}
			}

			this.packagedata = {data:{test: 'jason'}};
			this.loading = false;
		}
	},
	mounted(){
		// this.getPackageData();
	}
}
</script>
<style lang="scss" scoped>

</style>


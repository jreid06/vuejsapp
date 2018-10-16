<template>
	<div class="web-app-container">
		<app-nav></app-nav>
		<div class="app-body">
			<router-view></router-view>
		</div>
	</div>
</template>
<script>
import Appnav from './navigation/Dashnav.vue';

export default {
	components: {
		'app-nav': Appnav
	},
	data(){
		return {

		}
	},
	methods: {

	}
}
</script>
<style lang="scss">
	.web-app-container{
		position: relative;
	}
	.app-body{
		border-top: 1px solid #e8e8e8;
		position: relative;
		width: 100%;
		height: calc(100vh - 64px);
	
		overflow-y: scroll;
		top: 60px;
		left: 0;
		transition: all .4s ease-in-out;

		

		@media screen and (min-width: 768px){
			// padding-left: 15px;
		 	// padding-top: 15px;
			// padding-left: 125px;
			left: 203px;
			height: calc(100vh - 64px);
			width: calc(100% - 204px);
		}
	}

	.app-body-squashed{
		width: calc(100% - 250px);
		left: 252px;
	}
</style>

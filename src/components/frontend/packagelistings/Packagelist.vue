<template>
	<div class="front-end-inner inner-wrapper-div">
		<nav-frontend></nav-frontend>
		<div class="container-fluid">
			<p>test 1</p>
			<p>{{$route.params}}</p>
		</div>
	</div>
</template>
<script>
import Nav from "./../navigation/Nav.vue";

export default {
	components: {
		"nav-frontend": Nav
	},
	data(){
		return {
			
		}
	}	
}
</script>
<style lang="scss" scoped>
	p{
		margin-top: 150px;
	}
</style>

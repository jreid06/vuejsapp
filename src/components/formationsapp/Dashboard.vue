<template>
	<div class="container-fluid widgets-home">
		<div class="row">
			<team-stats></team-stats>
			<package-info></package-info>
			<div class="w-100"></div>
			<login-history></login-history>
			<team-stats></team-stats>
			<div class="w-100"></div>
			<top-players></top-players>
			<package-info></package-info>
		</div>
	</div>
</template>
<script>
import Loginhistory from './widgets/Loginhistory';
import Teamstats from './widgets/Teamstats';
import Packageinfo from './widgets/Packageinfo'
import TopPlayers from './widgets/TopPlayers'

export default {
	components:{
		'login-history': Loginhistory,
		'team-stats': Teamstats,
		'package-info': Packageinfo,
		'top-players': TopPlayers
	},
	data(){
		return{

		}
	}
}
</script>
<style lang="scss" scoped>

</style>


<template>
	<div class="col col-lg-4 widget-column teams-widget-column p-4">
		<div :class="{'fadeOut': !loading, 'fadeIn': loading}" class="d-flex lds-dual-ring loading-app-div h-100 w-100 justify-content-center align-items-center animated-fast"></div>
		<h5 class="p-2 text-light">My Teams</h5>
		<!-- <ul class="list-inline widget-list teams-widget-list">
			<template v-for="(team, i) in teams">
				<li class="list-inline-item px-1 text-capitalize" :class="{'d-none d-sm-block': i !== 0}" :key="i">
					<div class="d-flex flex-column flex-sm-row">
						<div class="py-2 pr-4 d-flex flex-column">
							<div><img :src="backend_config.http + backend_config.url + team.file_name" width="50" alt=""></div>
						</div>
						<div class="py-2 pr-4">
							<div class="font-weight-bold">{{team.team_name}}</div>
							<div class="">{{team.manager_name}}</div>
							<div class="">{{team.home_ground}}</div>
							<div>{{team.post_code}}</div>
						</div>						
					</div>
				</li>
			</template>
		</ul> -->
		<div class="row">
			<div class="col-12 text-capitalize" v-for="(team, i) in teams" :key="i" :class="{'d-none d-sm-block': i !== 0}">
				<div class="d-flex flex-column flex-sm-row">
					<div class="py-2 pr-4 d-flex flex-column">
						<div><img :src="backend_config.http + backend_config.url + team.file_name" width="50" alt=""></div>
					</div>
					<div class="py-2 pr-4 flex-fill text-center">
						<div class="font-weight-bold">{{team.team_name}}</div>
						<div class="">{{team.manager_name}}</div>
						<div class="">{{team.home_ground}}</div>
						<div>{{team.post_code}}</div>
					</div>						
				</div>
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
			loading: false,
			teams:[]
		}
	},
	methods:{
		getBasicTeamData(){
			this.$store.commit('addFileData', {dataArray: this.$store.getters.returnTeamsData, key: 'team_emblem_single'});
			this.teams = this.$store.getters.returnWidgetTeamsData;
		}
	},
	mounted(){
		this.getBasicTeamData();
	}
}
</script>
<style lang="scss" scoped>
.teams-widget-column{
	// border: 1px solid red;
	//   height: 400px;
  font-size: 12.5px;
  border-left: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
//   border-right: 1px solid #e5e5e5;
  box-shadow: 0 0 3px #e5e5e5;

	@media screen and (min-width: 992px){
		// width: 20% !important;
	}

	@media screen and (min-width: 1200px){
		width: 20% !important;
	}
}
</style>


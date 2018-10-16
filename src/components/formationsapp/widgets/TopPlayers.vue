<template>
	<div class="col col-lg-6 widget-column players-widget-column p-4">
		<div :class="{'send-to-back fadeOut': !loading, 'fadeIn': loading}" class="d-flex lds-dual-ring loading-app-div d-none h-100 w-100 justify-content-center align-items-center animated-fast"></div>
		<h5 class="p-2 text-light">Top Players</h5>
		<div class="row">
			<div class="col-12 d-md-flex flex-row">
				<div class="player dp-logo">
					<div class="player-dp p-3">
						<img :src="`${backend_config.http}/${backend_config.url}//storage/uploads/00000000013.png`" width="40" alt="">
					</div>
					<div class="player-team-emblem p-3">
						<img :src="`${backend_config.http}/${backend_config.url}/storage/uploads/00000000012.png`" width="40" alt="">
					</div>
				</div>
				<!--  -->
				<div class="player details d-flex align-items-center flex-wrap text-center">
					<div class="p-2">Nacho Monreal</div>
				</div>

				<div class="player details d-flex align-items-center flex-wrap text-center">
					<div class="p-2"><strong>(LB)</strong><br><span class="font-italic"></span></div>
				</div>
				<!--  -->
				<!-- if player is GK add dynamic class keeper stats -->
				<div class="player attack-stats d-flex align-items-center flex-wrap text-center">
					<div class="py-2">
						<strong>Goals</strong>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" style="width: 4%" aria-valuemin="0" aria-valuemax="10"></div>
						</div>
					</div>
					<div class="py-2">
						<strong>Assists</strong>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="" style="width: 2%" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
				<!--  -->
				<div class="player booking-stats d-flex align-items-center flex-wrap text-center">
					<div class="py-2">
						<strong>Yellow cards</strong>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="0" style="width: 9%" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="py-2">
						<strong>Red cards</strong>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="" style="width: 4%" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
				<!--  -->
				<div class="player games-played text-center d-flex align-items-center flex-wrap text-center">
					<div class="py-2">
						<strong class="cus-pos">Games Played</strong>
					</div>
					<div class="py-2">
						<div class="h4"><i class="fas fa-chart-pie"></i></div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { globalMixin } from "./../../../mixins/globalmixin.js";

export default {
  mixins: [globalMixin],
  data() {
    return {
      loading: false,
      players: []
    };
  },
  methods:{
	  
  }
};
</script>
<style lang="scss" scoped>
.player {
//   border: 1px solid;
  font-size: 12.5px;

  &.details {
    > div {
      width: 100%;
    }
  }
  &.attack-stats {
   @media screen and (min-width: 768px){
	   width: 150px;
   }
    > div {
      width: 100%;
    }

    .progress {
      width: 60%;
      margin: 0 auto;
    }
  }

  &.booking-stats {
   @media screen and (min-width: 768px){
	   width: 150px;
   }
    > div {
      width: 100%;
    }

    .progress {
      width: 60%;
      margin: 0 auto;
    }
  }

  &.games-played {
    > div {
      width: 100%;
    }
  }

  .cus-pos{
	  position: relative;
	  @media screen and (min-width: 768px){
		  top: -3.3px;
	  }
  }	
}
</style>

<template>
	<div class="col widget-column login-widget-column p-4">
		<h5 class="p-2 text-light">Login History</h5>
		<ul class="list-group login-widget-list">
			<template v-for="(history, i) in login_history.real" v-if="">

				<li class="list-group-item px-1" :class="{'d-none d-sm-block': i !== 0}" :key="i" v-if="!history.hasOwnProperty('error')">
					<div class="d-flex flex-column flex-sm-row">
						<div class="py-2 pr-4 d-flex flex-column">
							<div class="font-weight-bold">{{history.date_uk.split(' ')[0]}}</div>
							<div class="">{{history.time}}</div>
						</div>
						<div class="py-2 pr-4">
							<div class="font-weight-bold">{{history.ip.geoplugin_city}}</div>
							<div class="">{{history.ip.geoplugin_countryName}}&nbsp;&nbsp; <span class="badge badge-success badge-pill">{{history.ip.geoplugin_countryCode}}</span> </div>
						</div>
						<div class="py-2 pr-4">
							<div class="font-weight-bold">Device type</div>
							<div class=" text-muted d-flex flex-column flex-sm-row">
								<div>
									<span class="badge-label">{{history.device.brand}}&nbsp;</span>
									<span class="badge badge-info badge-pill">
										<i :class="'fab fa-'+ history.device.brand.toLowerCase()"></i>
									</span>
									&nbsp;
								</div> 
								<div>
									<span class="badge-label">{{history.device.clientInfo.name}}&nbsp;</span>
									<span class="badge badge-info badge-pill">
										<i :class="'fab fa-'+history.device.clientInfo.name.toLowerCase()"></i>
									</span>
									&nbsp;
								</div>
								<div>
									<span class="badge-label">{{history.device.osInfo.name}}&nbsp;</span>
									<span class="badge badge-info badge-pill">
										<i :class="'fab fa-'+ history.device.brand.toLowerCase()"></i>
									</span>
								</div>
							</div>
						</div>
						<div class="py-2 ml-sm-auto">
							<div class="font-weight-bold">IP Address</div>
							<div class=""><span class="badge badge-warning badge-pill">{{history.ip.geoplugin_request}}</span> </div>
						</div>
						
					</div>
				</li>
				<!--  -->
				<li class="list-group-item px-1" :class="{'d-none d-sm-block': i !== 0}" :key="i" v-else>
					<div class="d-flex flex-column flex-sm-row">
						<div class="py-2 pr-4 d-flex flex-column">
							<div class="font-weight-bold">{{history.date_uk.split(' ')[0]}}</div>
							<div class="">{{history.time}}</div>
						</div>
						<div class="p-2 w-100 bg-danger text-center br-3">
								<h6 class="text-light">Error recording login geolocation & browser data. Contact help if error persists</h6>
						</div>

					</div>
				</li>
			</template>

		</ul>
			<div :class="{'fadeOut send-to-back': !loading, 'fadeIn': loading}" class="d-flex loading-app-div lds-dual-ring h-100 w-100 justify-content-center align-items-center animated-fast"></div>
	</div>
</template>
<script>
import { globalMixin } from "./../../../mixins/globalmixin";

export default {
  mixins: [globalMixin],
  data() {
    return {
      loading: false,
      login_history: {
        json: "",
        real: ""
      }
    };
  },
  watch: {
    "login_history.json": function(val) {
      const vm = this;

      //  let data = JSON.parse(JSON.stringify(val));

      let isJSON = vm.returnJSON(val);
      if (isJSON) {
        vm.login_history.real = isJSON.reverse().splice(0, 5);
      }
    }
  },
  methods: {
    getLoginHistory() {
      const vm = this;
      vm.login_history.json = vm.$store.getters.returnLoginHistory;
    }
  },
  mounted() {
    // get login history
    this.getLoginHistory();
  }
};
</script>
<style lang="scss">
.login-widget-column {
//   height: 400px;
  font-size: 12.5px;
  border-left: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
  border-right: 1px solid #e5e5e5;
  box-shadow: 0 0 3px #e5e5e5;
}

.badge-label{
	font-size: 12px;
}

.widget-list{

}

.list-group-item {
	border: 0px solid;
}

.login-widget-list {
//   border: 1px solid gold;
	
		&:nth-child(2n+1){
			background-color: lighten(#e5e5e5, 5%);
		}
}
</style>



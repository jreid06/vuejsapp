<template>
	<div class="front-end-inner inner-wrapper-div h-100-vh">
		<nav-frontend></nav-frontend>
		<!--  -->
		<!--  -->
		<!--  -->
		<div class="container-fluid" v-if="account === 'manager'">
			<div class="row pt-5">
				<div class="col-12 p-4 bg-primary-green text-center">
					<h3 class="text-capitalize p-5 text-light">{{account}} packages</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-12 text-center">
					<div class="package-card-div">
						<div class="row justify-content-center">
							<div class="col-12 col-sm-6 col-md-4 pb-4 justify-content-center" :data-key="i" v-for="(accPackage, i) in packageInfo" :key="i">
								<div class="card mr-3 d-inline-block mt-2">
									<div class="card-body text-center">
										<h3 class="card-title">{{accPackage.package_name}}</h3>
										<div v-html="accPackage.package_description.html"></div>

										<ul class="list-style-none">
											<li>
												Team limit:
												<span class="package-data text-success font-weight bold">
													{{accPackage.team_limit}}
												</span>
											</li>
											<li>
												Players Per Team: 
												<span class="package-data text-success font-weight bold">
													{{accPackage.players_per_team}}
												</span>
											</li>
											<li>
												Formation Variations Per Team: 

												<span class="package-data text-success font-weight bold">
													{{accPackage.formation_variations_per_team}}
												</span>
											</li>
											<li>
												<accordion 
														:uniqueid="accPackage.package_slug"
														:rawlistdata="accPackage.player_stats" 
														title="Player Stats">
												</accordion>
											</li>

										</ul>
										<div class="p-3">
											<h4><span class="font-weight-bold">£</span>{{accPackage.package_type_cost}} / month </h4>
										</div>

										<a
											:data-to="'/signup/'+ account + '/' + accPackage.package_slug" 
											class="card-link btn btn-primary-green" 
											:data-package="accPackage.id" 
											:data-account="accPackage.account_linked_to"
											:data-location="i"
											@click="updatePackageSelection"
											v-if="accPackage.paid_package" >
											Select Package
										</a>
										<a
											:data-to="'/signup/'+ account + '/' + accPackage.package_slug" 
											class="card-link btn btn-secondary" 
											:data-package="accPackage.id" 
											:data-account="accPackage.account_linked_to" 
											:data-location="i"
											@click="updatePackageSelection"
											v-else>
											Select Package
										</a>

									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!--  -->
		<!--  -->
		<!--  -->
		<div class="container-fluid" v-if="account === 'player'">
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<div class="card mr-3 d-inline-block" v-for="(accPackage, i) in packageInfo" :key="i">
						<div class="card-body text-center">
							<h3 class="card-title">{{accPackage.package_name}}</h3>
							<div v-html="accPackage.package_description.html"></div>

							<ul class="list-style-none">
								<li>
									<accordion 
											:uniqueid="accPackage.package_slug"
											:rawlistdata="accPackage.player_stats" 
											title="Player Stats">
									</accordion>
								</li>
							</ul>

							<div class="p-3">
								<h4><span class="font-weight-bold">£</span>{{accPackage.package_type_cost}} / month</h4>
							</div>

							<a
								:data-to="'/signup/'+ account + '/' + accPackage.package_slug" 
								class="card-link btn btn-primary-green" 
								:data-package="accPackage.id" 
								:data-account="accPackage.account_linked_to"
								:data-location="i"
								@click="updatePackageSelection"
								v-if="accPackage.paid_package" >
								Select Package
							</a>
							<a
								:data-to="'/signup/'+ account + '/' + accPackage.package_slug" 
								class="card-link btn btn-secondary" 
								:data-package="accPackage.id" 
								:data-account="accPackage.account_linked_to" 
								:data-location="i"
								@click="updatePackageSelection"
								v-else>
								Select Package
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import { router } from "./../../../main.js";
import { mapGetters } from "vuex";
import { mapMutations } from "vuex";
import Nav from "./../navigation/Nav.vue";
import Accordion from "./../elements/Singleaccordion.vue";

export default {
  components: {
    "nav-frontend": Nav,
    accordion: Accordion
  },
  data() {
    return {
      // packageInfo: this.$store.getters.getPackageInfo('manager'),
      account: this.$route.params.account_type,
      packageInfo: this.$store.getters.getPackageInfo(
        this.$route.params.account_type
      ),
      styleobj: {}
    };
  },
  computed: {
    ...mapGetters(["getPackageInfo", "returnUserDetails"])
  },
  methods: {
    ...mapMutations(["updateUserDetails"]),
    updatePackageSelection(e) {
      let obj = this.returnUserDetails,
        package_id = e.target.attributes["data-package"].value,
				account_id = e.target.attributes["data-account"].value,
				pos = e.target.attributes["data-location"].value,
				path = e.target.attributes["data-to"].value;
				
			this.$store.state.register_module.register.package_details = this.packageInfo[pos];

      obj.package_id = package_id;
			obj.account_type_id = account_id;

			// created keys
			// will be updated in the register array via updateUserDetails
			obj.package_details = this.packageInfo[pos];
			obj.account_details = this.$store.getters.returnAccountDetails;			

      // update our $store register object with package & account details
      this.updateUserDetails(obj);

      // redirect user to the signup page for the specific course & account
      router.push({ path: path });
    }
  }
};
</script>
<style lang="scss" scoped>

$primary_green: #42b983;

.container-fluid {
  transition: all 0.5s ease-in-out;
}

.bg-primary-green{
	background-color: $primary_green;
}

.card {
  width: 100%;
  max-width: 25rem;
}

.h-100-vh {
  height: 100vh;
}
</style>


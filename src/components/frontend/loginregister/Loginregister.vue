<template>
	<div class="front-end-inner inner-wrapper-div">
    <keep-alive>
		  <nav-frontend></nav-frontend>
    </keep-alive>
		<div class="justify-content-center align-items-center custom-margin h-100-vh">
			<div class="d-flex container h-100 custom-margin custom-margin-login" v-if="route === '/login'">
				<div class="row w-100">
          <!--  -->
         <!--  -->
					<div class="col-12 d-flex justify-content-center align-items-center">
						<form class="form-generic-sizing text-center pt-2 pt-sm-0 pb-5" >
              <div class="form-group">
                 <div class="alert animated fadeIn text-center" :class="login.error.alertClass" role="alert" v-if="login.error.status">
                  {{login.error.message}}
                 </div>
              </div>
							<div class="form-group">
								<h3>Login</h3>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="loginEmail" aria-describedby="emailHelp" placeholder="Enter email" v-model.trim="login.form.email">
								<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="loginPassword" placeholder="Password" v-model.trim="login.form.password">
							</div>
							
							<button type="submit" class="btn btn-primary-green" @click.prevent="loginUser">Submit</button>
						</form>
					</div>
				</div>
			</div>
      
      <!--  -->
			<div class="d-flex flex-column justify-content-center container h-100 custom-margin" v-else>
				<div class="row">
					<div class="col-12">
            <div class="reg-cards-div pt-md-0">
              <div class="row">
                  <div class="col pb-4" v-for="(account, i) in register.accountTypes" :key="i">
                    	<div class="card register-card text-center m-auto p-xs-1 p-md-5">
                        <div class="card-body">
                          <img :src="backend_config.http+backend_config.url+account.account_icon.data.url" width="100" height="100" class="img-fluid mb-3" alt="">
                          <h4 class="card-title pb-2">{{account.account_name}}&nbsp;Account</h4>
                          <p class="card-text pb-2">{{account.account_description}}</p>

                          <!-- click.native is for router links to send click to rendered 'a' tag -->
                          <a class="btn btn-primary-green" 
                                  @click="updateAccountInfo" 
                                  :data-account-type="account.account_name.toLowerCase()"
                                  :data-location="i"
                                  v-if="account.account_name === 'Manager'">
                                  Become a {{account.account_name}}
                          </a>

                          <!-- click.native is for router links to send click to rendered a tag -->
                          <router-link class="btn btn-secondary" 
                                  :to="'join/'+account.account_name.toLowerCase() +'/packages'" 
                                  @click.native="updateAccountInfo" 
                                  :data-location="i"
                                  v-else>
                            Be a {{account.account_name}}
                          </router-link>
                          
                        </div>
                      </div>
                  </div>
                  <div class="col-12 pt-3 text-center">
                    <h6>
                      Not sure what account you need? <br><br>
                      <router-link to="/features">Read our features page</router-link>
                    </h6>
                  </div>
              </div>
            </div>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import Nav from "./../navigation/Nav.vue";
import { globalMixin } from "./../../../mixins/globalmixin.js";
import { router } from "./../../../main.js";

export default {
  mixins: [globalMixin],
  components: {
    "nav-frontend": Nav
  },
  data() {
    return {
      templateStatus: {
        error: false,
        message: "",
        loading: false
      },
      login: {
        form: {
          email: "",
          password: ""
        },
        error: {
          status: false,
          message: "",
          alertClass: ""
        }
      },
      route: this.$route.fullPath,
      register: {
        accountTypes: this.$store.state.accountTypes
      }
    };
  },
  watch: {
    $route: function(changedRoute) {
      this.route = changedRoute.fullPath;
    },
    route: function(changedRoute) {
      const vm = this;
      if (changedRoute === "/register") {
        if (vm.register.accountTypes.length <= 0) {
          vm.getAccountTypes();
          vm.$store.commit('initRegister');
        }
      }
    }
  },
  computed: {},
  methods: {
    loginUser() {
      const vm = this;
      const result = this.JOI_loginValidate(this.login.form);

      console.log(result);

      if (result.error === null) {
        // send request to login user
        // use a promise
        $.post("/scripts/login.php", { data: this.login.form }, response => {
          let user = response.info.user;

          switch (response.status.code) {
            case 200:
              if (!vm.login.error.status) {
                vm.login.error.status = !vm.login.error.status;
              }

              vm.login.error.message = response.info.message;
              vm.login.error.alertClass = response.status.code_status;

              // set the store login module with user details & session
              vm.$store.dispatch("updateSession", response.info);

              // redirect user to dashboard home

              // console.log(user.data);

              vm.redirectUser(
                router,
                `/app/dashboard/home/${user.data.account_id_code}`,
                3000
              );

              break;
            case 400:
              if (!vm.login.error.status) {
                vm.login.error.status = !vm.login.error.status;
              }

              vm.login.error.message = response.info.message;
              vm.login.error.alertClass = response.status.code_status;

              break;
          }
        }).fail(error => {
          console.log("LOGIN ERROR");
          console.log(error);
        });
      } else {
        if (!vm.login.error.status) {
          vm.login.error.status = !vm.login.error.status;
        }
        vm.login.error.message = "Please fill in the required fields";
        vm.login.error.alertClass = "alert-danger";

        setTimeout(function() {
          vm.login.error.status = false;
        }, 3500);
      }
    },
    updateAccountInfo(e) {
      let account_type = e.target.dataset.accountType;

       // update the store directly with account data
      this.$store.state.register_module.register.account_details = this.register.accountTypes[
        parseInt(e.target.attributes["data-location"].value)
      ];
      
      router.push({path: `/join/${account_type}/packages`});
    },
    getAccountTypes() {
      const vm = this;
      if (vm.$store.state.accountTypes > 0) {
        vm.register.accountTypes = vm.$store.state.accountTypes;
      } else {
        console.log("GET ACCOUNT TYPES LOCAL INIT");

        vm.$store.commit("setAccountTypes");
      }
    },
    initComponent() {
      this.getAccountTypes();
      this.$store.commit('initRegister');
    },
  },
  mounted() {
    this.initComponent();
  }
};
</script>
<style lang="scss" scoped>
.custom-margin {
  transition: all ease-in-out 0.5s;
  // top: 80px;
}

.reg-cards-div{
  padding-top: 100px;
  padding-bottom: 15px;

  @media screen and (min-width: 768px) {
    padding-top: 0px;
  }
}


.register-card {
  border: 0px solid;
}
</style>

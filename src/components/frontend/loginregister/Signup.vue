<template>
	<div class="front-end-inner inner-wrapper-div">
		<div class="container-fluid h-100-vh border justify-content-center align-items-center d-md-flex">

			<div class="row">
				<div class="col-12 px-2 px-md-0">
					<div class="card post-card-style m-auto">
						<div id="loading-div" class="lds-dual-ring loading h-100 w-100 d-none justify-content-center align-items-center animated-fast"></div>
						<div class="card-body">
							<div class="row" v-if="form.message_obj.showMessage">
								<div class="col-12">
									<div class="alert fade show signup-alert text-center" :class="{'alert-danger': form.message_obj.errStatus, 'alert-success': !form.message_obj.errStatus}" role="alert">
										{{form.message_obj.message}}
									</div>
								</div>
							</div>
							<div class="row" v-if="!signup_success">
								<div class="col-12 col-sm-7 col-lg-7">
									<form @submit.prevent="checkForm" class="p-3">
										<div class="form-row">
											<div class="col">
												<div class="form-group">
													<label for="fname" class="text-capitalize pb-1">first name</label>
													<input type="text" v-model="form.first_name" class="form-control form-control-sm" name="fname" id="fname" placeholder="First Name">
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<label for="fname" class="text-capitalize pb-1">last name</label>
													<input type="text" v-model="form.last_name" class="form-control form-control-sm" name="lname" id="lname" placeholder="Last Name">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="email" class="text-capitalize pb-1">email</label>
													<input type="email" v-model="form.email" class="form-control form-control-sm" name="email" id="email" placeholder="Email Address">
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<label for="password" class="text-capitalize pb-1">password</label>
													<input type="password" v-model="form.password" class="form-control form-control-sm" name="password" id="password" placeholder="Password">
													<small class="text-muted">Must be 3 characters long and contain symbols</small>
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<fieldset disabled>
														<label for="acctype" class="text-capitalize pb-1">account selected</label>
														<input type="text" name="acctype" id="acctype" :value="form.account_type_data.account_name" class="form-control">
													</fieldset>
												</div>
											</div>
											<div class="col">
												<div class="form-group">
													<fieldset disabled>
														<label for="packagetype" class="text-capitalize pb-1">package selected</label>
														<input type="text" name="packagetype" id="packagetype" :value="form.package_data.package_name" class="form-control">
													</fieldset>
												</div>
											</div>
											<div class="col-12">
												<div class="form-group">
													<br>
													<button type="submit" class="btn btn-primary-green p-2">Create your <span class="text-capitalize">{{form.account_type_data.account_name}}</span> account</button>
												</div>
											</div>
										</div>
									</form>
									<!-- <div class="half-divider"></div> -->
								</div>
								<div class="col-12 col-sm-5 col-lg-5 info-column pt-3">
									<h5 class="font-weight-bold text-center">Account & Package Info</h5>
									<div class="text-center pt-1">
										<img :src="backend_config.http + backend_config.url + returnAccountDetails.account_icon.data.url"  width="50" height="50" alt="">
									</div>
									<ul class="list-style-none list-inline text-center h-100">
										<li class="list-inline-item w-100" :style="styleobj">
											<h5>Account: <span class="font-weight-bold text-primary-green">{{returnAccountName}}</span></h5>
											<small>{{returnAccountDetails.account_description}}</small>
										</li>
										<li class="list-inline-item w-100" :style="styleobj">
											<h5>Package: <span class="font-weight-bold text-primary-green">{{returnPackageDetails.package_name}}</span></h5>
											<small v-html="returnPackageDetails.package_description.html"></small>
										</li>
									</ul>
								</div>
							</div>
							<div class="row" v-else>
								<div class="col-12 pt-3 text-center">
									<h1 class="display-1"><i class="far fa-check-circle text-primary-green"></i></h1>
									<br>
									<router-link to="/login" class="btn btn-primary-green">Login to your account <span class="text-capitalize">{{form.first_name}}</span></router-link>
								</div>
							</div>
						</div>
					</div>
					<div class="m-auto pt-5 text-center" v-if="!signup_success">
						<p>Already have and account? <router-link to="/login" class="text-primary-green">Login</router-link></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
const Joi = require("joi-browser");

import { mapGetters, mapMutations } from "vuex";
import { globalMixin } from "./../../../mixins/globalmixin";

export default {
  mixins: [globalMixin],
  data() {
    return {
      form: {
        message_obj: {
          message: "",
          errorClass: "",
          showMessage: false,
          errStatus: false
        },
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        account_type_data: this.$store.getters.returnAccountDetails,
        package_data: this.$store.getters.returnPackageDetails
      },
      loading: false,
      signup_success: false,
      styleobj: {
        border: "0px solid green",
        padding: "30px 5px"
      },
      userAccountDetails: this.$store.getters.returnUserDetails
    };
  },
  computed: {
    ...mapGetters([
      "returnUserDetails",
      "returnAccountName",
      "returnAccountDetails",
      "returnPackageDetails"
    ])
  },
  methods: {
    ...mapMutations(["updateUserDetails"]),
    toggleLoadingElement(load) {
      // make the component visable
      this.loading = load;

      // get the element object
      let loadingElement = document.getElementById("loading-div");

      // show element in console
      console.log(loadingElement);

      if (load) {
        // only remove the fadeOut class if it exists on element
        if (loadingElement.classList.contains("fadeOut")) {
          loadingElement.classList.remove("fadeOut");
        }

        //
        if (loadingElement.classList.contains("d-none")) {
          loadingElement.classList.remove("d-none");
          loadingElement.classList.add("d-flex");
        }

        // add fade in class regardless
        loadingElement.classList.add("fadeIn");
      } else {
        if (loadingElement.classList.contains("fadeIn")) {
          loadingElement.classList.remove("fadeIn");
        }

        // add fadeOut regardless
        loadingElement.classList.add("fadeOut");

        setTimeout(function() {
          // add d-none class back to loading
          if (loadingElement.classList.contains("d-flex")) {
            loadingElement.classList.remove("d-flex");

            loadingElement.classList.add("d-none");
          }
        }, 1600);
      }
    },
    checkForm() {
      // validate inputed form data
      const vm = this;
      const result = this.JOI_registerValidate(this.form);

      console.log(result);
      

      if (result.error === null) {

        // update store data with validated user info
        vm.updateUserDetails(vm.form);

        // register user
        vm.toggleLoadingElement(true);

        setTimeout(function() {
          vm.registerUser(vm.returnUserDetails);
        }, 1300);
      } else {
        vm.setMessageData({
          showMessage: true,
          message: result.error.details[0].message,
          errStatus: true,
          errorClass: "btn-primary"
        });
      }
    },
    setMessageData(err) {
      const vm = this;
      for (const key in err) {
        if (vm.form.message_obj.hasOwnProperty(key)) {
          vm.form.message_obj[key] = err[key];
        }
      }
    },
    registerUser(formdata) {
      const vm = this;
      console.log("register user to their selected package");
      console.log(formdata);

      $.ajax({
        type: "post",
        url: "/scripts/register.php",
        data: formdata,
        success(response) {
          switch (response.status.code) {
            case 200:
              vm.setMessageData({
                showMessage: true,
                errStatus: false,
                message: response.info.message
              });

              // hide loading element
              vm.toggleLoadingElement(false);

              // set signup_success to true
              vm.signup_success = true;
              break;
            case 400:
              vm.setMessageData({
                showMessage: true,
                errStatus: true,
                message: response.info.message
              });

              // hide loading element
              vm.toggleLoadingElement(false);
              break;

            default:
              break;
          }
        },
        error() {}
      });
    }
  }
};
</script>
<style lang="scss" scoped>
$primary_green: #42b983;

.loading {
  position: absolute;
  background-color: darken(#fff, 4%);
  top: 0;
  left: 0;
  z-index: 10;
}

.info-column {
  border: 1px solid #e5e5e5ab;
  // padding-top: 20px;

  border-radius: 10px;
  background-color: #e5e5e5ab;

  @media screen and (min-width: 568px) and (max-width: 767px) {
    //  margin-top: -20px;
  }

  @media screen and (min-width: 992px) {
    // margin-top: -20px;
  }
}

.half-divider {
  border: 1px solid #e5e5e5;
  height: 70%;
  position: absolute;
  top: 15%;
  right: -10px;
}

.post-card-style {
  position: relative;
  transition: all 0.2s ease-in-out;
  border: 1px solid #e5e5e5;
  box-shadow: 0 2px 3px $primary_green;
  padding: 10px;

  @media screen and (min-width: 768px) {
    width: 45rem;
    padding: 15px;
  }

  @media screen and (min-width: 992px) {
    // width: 28rem;
    padding: 15px;
  }

  @media screen and (min-width: 1200px) {
    // width: 40rem;
  }
}
</style>


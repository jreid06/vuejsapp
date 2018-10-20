<template>
	<nav class="navbar navbar-expand-lg navbar-light w-100 fixed-top" :class="navclass.transparent.status ? 'no-bg' : navclass.color.class">
		<a class="navbar-brand font-italic font-weight-bold" href="#">FF</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarColor03">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" :href="globalHref+'/'">Home<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" :href="globalHref+'/'">Features</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" :href="globalHref+'/'">Pricing</a>
				</li>
				
        <template v-if="!$store.getters.returnLoginStatus">
          <li class="nav-item">
            <router-link class="nav-link btn btn-outline-secondary" to="/register">Register</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link btn btn-outline-success" to="/login">Login</router-link>
          </li>
        </template>
        <template v-else>
           <li class="nav-item">
            <router-link class="nav-link btn btn-outline-success" :to="`/app/dashboard/home/${$store.getters.returnUserIDs.account_id}`">Dashboard</router-link>
          </li>
          <li class="nav-item">
            <span class="nav-link btn btn-outline-success" @click="logout"><i class="fas fa-power-off"></i></span>
          </li>
        </template>
				
				
			</ul>
		</div>
	</nav>
</template>

<script>
import {mapMutations} from 'vuex';
import {globalMixin} from './../../../mixins/globalmixin.js';

export default {
  mixins:[globalMixin],
  data: function() {
    return {
      globalHref: '#',
      scrollSettings: {
        scrollPosition: window.scrollY,
        scrollThreshold: window.innerHeight
      },
      navclass: {
        transparent: {
          status: true
        },
        color: {
          status: false,
          class: "bg-light nav-boxshadow"
        }
      }
    };
  },
  watch: {
    "scrollSettings.scrollPosition": function(h) {
      if (h > this.scrollSettings.scrollThreshold) {
        this.navclass.transparent.status = false;
        this.navclass.color.status = true;

        return;
      }

      this.navclass.color.status = false;
      this.navclass.transparent.status = true;
    }
  },
  methods: {
    updateScrollPosition() {
      // update scroll position on page load
      this.scrollSettings.scrollPosition = window.scrollX;
    },
    checkScrollPosition(e) {
      let element_boundary = document.getElementById("landing-section"),
        vm = this;
      window.addEventListener("scroll", function() {
        vm.scrollSettings.scrollPosition = window.scrollY;
      });
    }
  },
  destroyed() {
    console.log("nav destroyed");
  },
  mounted() {
    const vm = this;
    if (this.$route.fullPath === "/") {
      console.log("HOME PAGE");
      vm.updateScrollPosition();
      vm.checkScrollPosition();
    } else {
      vm.navclass.transparent.status = false;
      vm.navclass.color.status = true;
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar {
  border-style: none !important;
  transition: all 0.5s ease-in-out;
}

.nav-boxshadow {
  box-shadow: 0 3px 3px #e3e3e3;
}

.no-bg {
  color: #fff;

  a {
    color: #fff;
  }

  .nav-link {
    color: #fff;
    // font-weight: bold;
  }
}

.nav-item:nth-child(n){
  margin-right: 20px;
}
</style>


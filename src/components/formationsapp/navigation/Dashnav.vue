<template>
	<!-- show mobile nav menu -->
	<div id="nav-container" v-if="device.mobile">
		<nav class="topbar-mobile navbar w-100 align-items-center">
			<a href="" class="navbar-brand">FF</a>
			<a href="" @click.prevent="toggleMobileMenu"><i class="fas fa-bars"></i></a>
		</nav>

		<nav class="sidebar-mobile" :class="{'sidebar-closed':mobileMenu.closed, 'sidebar-open':mobileMenu.open}" @mouseleave="closeMenu">
			<ul>
				<!-- <li class="text-left" v-for="(link, index) in sidebarMenuLinks" :key="index">
					<div class="dropdown">
						<a class="dropdown-toggle" :id="'dropdownMenu'+index" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i :class="link.icon"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right text-capitalize text-center" :aria-labelledby="'dropdownMenu'+index">
							<template v-for="(sublinks, index) in link.dropdownLinks">
								<template v-if="sublinks.divider">
									<a class="dropdown-item" :href="sublinks.href" :key="index">{{sublinks.title}}</a>
									<div class="dropdown-divider" :key="'divider'+index"></div>
								</template>
								<template v-else>
									<a class="dropdown-item" type="button" :href="sublinks.href" :key="index">{{sublinks.title}}</a>
								</template>
							</template>
						</div> 
					</div>
				</li> -->
        	<li class="text-left" v-for="(link, index) in sidebarMenuLinks" :key="index">
          <div class="active-link" v-if="link.href === hash"></div>
					<!-- <div class="dropdown"> -->
						<router-link class="" :id="'dropdownMenu'+index" aria-haspopup="true" aria-expanded="false" :to="link.href">
							<i :class="link.icon"></i>
							<template>
								<span class="text-capitalize animated-delay fadeIn pl-3">{{link.title}}</span>
							</template>
						</router-link>
					<!-- </div> -->
				</li>
			</ul>
		</nav>
	</div>

	<!-- show desktop nav menu -->
	<div id="nav-container" v-else>
		<nav class="navbar topbar d-flex flex-row justify-content-end">
			<div class="pr-5">
				<form class="form-inline">
      				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div>
			<ul class="topbar-nav-links">
				<li class="" v-for="(link, index) in topbarMenuLinks" :key="index">
					<div class="dropdown">
						<a class="dropdown-toggle" :id="'dropdownMenu'+index" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i :class="link.icon"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right text-capitalize text-center animated-fast flipInX" :aria-labelledby="'dropdownMenu'+index">
							<template v-for="(sublinks, index) in link.dropdownLinks">
								<template v-if="sublinks.divider">
									<a class="dropdown-item" :href="sublinks.href" :key="index">{{sublinks.title}}</a>
									<div class="dropdown-divider" :key="'divider'+index"></div>
								</template>
								<template v-else>
									<a class="dropdown-item" :href="sublinks.href" :key="index" v-if="sublinks.hasOwnProperty('click')" @click="sublinks.click">{{sublinks.title}}</a>
                  <a class="dropdown-item" :href="sublinks.href" :key="index" v-else>{{sublinks.title}}</a>
								</template>
							</template>
						</div>
					</div>
				</li>
			</ul>
		</nav>

		<nav class="sidebar" :class="{'expanded':sidebarMenu.expanded}">
      <div class="brand justify-content-center d-flex align-items-center">
        	<a href="" class="navbar-brand">FF</a>
      </div>
			<ul class="w-100 sidebar-links">
				<li class="text-left" v-for="(link, index) in sidebarMenuLinks" :key="index">
          <div class="animated bounceIn active-link" v-if="link.href === hash" ></div>
					<!-- <div class="dropdown"> -->
						<router-link class="" :id="'dropdownMenu'+index" aria-haspopup="true" aria-expanded="false" :to="link.href">
							<i :class="link.icon"></i>
							<template>
								<span class="text-capitalize animated-delay fadeIn pl-3">{{link.title}}</span>
							</template>
						</router-link>
					<!-- </div> -->
				</li>
			</ul>
			<div class="menu-width-toggle w-100">
				<div :class="{'expanded-color': !sidebarMenu.expanded}"><i class="fas fa-arrows-alt-h"></i></div>
			
			</div>
		</nav>

	</div>
</template>
<script>
import { router } from "./../../../main";
import { globalMixin } from "./../../../mixins/globalmixin.js";

export default {
  mixins: [globalMixin],
  data() {
    return {
      currentHref: "",
      hash: "",
      userID: this.$store.getters.returnUserIDs.account_id,
      device: {
        mobile: false,
        desktop: true
      },
      mobileMenu: {
        open: false,
        closed: true
      },
      sidebarMenu: {
        small: true,
        expanded: false
      },
      sidebarMenuLinks: [
        {
          icon: "fas fa-home",
          title: "dashboard",
          href: `/app/dashboard/home/${
            this.$store.getters.returnUserIDs.account_id
          }`,
          dropdown: true
        },
        {
          icon: "fas fa-shield-alt",
          title: "teams",
          href: `/app/teams/all/${
            this.$store.getters.returnUserIDs.account_id
          }`,
          dropdown: true
        },
        {
          icon: "fas fa-users",
          title: "player catalogue",
          href: "/app/players/catalogue",
          dropdown: true
        },
        {
          icon: "fas fa-chart-pie",
          title: "Visual Stats",
          href: "",
          dropdown: true
        }
      ],
      topbarMenuLinks: [
        {
          icon: "far fa-user",
          title: "profile",
          dropdownLinks: [
            {
              title: "signed in as " + this.$store.getters.returnUserName,
              divider: true,
              href: "#"
            },
            {
              title: "logout",
              divider: false,
              click: this.logout,
              href: "#"
            }
          ]
        },
        {
          icon: "fas fa-cog",
          title: "settings",
          dropdownLinks: [
            {
              title: "my account",
              divider: false,
              href: "#"
            },
            {
              title: "Sessions",
              divider: false,
              href: "#"
            },
            {
              title: "billing ",
              divider: false,
              href: "#"
            }
          ]
        }
      ]
    };
  },
  watch: {
    "device.mobile": function(val) {},
    $route: function(val) {
      // check if route changes in app to update navigation
      this.getHash();

      // close menu when route changes if its open
      this.closeMenu();
    }
  },
  methods: {
    closeMenu() {
      const vm = this;
      // check if device is mobile
      if (vm.device.mobile) {
        // close menu if its open and device is mobile
        if (vm.mobileMenu.open) vm.toggleMobileMenu();
      }
  
    },
    toggleMobileMenu() {
      const vm = this;
      let mobileSidebar = document.querySelector(".sidebar-mobile");

      console.dir(mobileSidebar);
      if (vm.mobileMenu.closed) {
        vm.mobileMenu.closed = !vm.mobileMenu.closed;
        vm.mobileMenu.open = !vm.mobileMenu.open;

        return;
      }

      if (vm.mobileMenu.open) {
        vm.mobileMenu.open = !vm.mobileMenu.open;
        vm.mobileMenu.closed = !vm.mobileMenu.closed;

        return;
      }
    },
    checkDeviceType() {
      const vm = this;

      if (window.innerWidth < 768) {
        vm.device.mobile = true;
        vm.device.desktop = false;
      } else {
        vm.device.mobile = false;
        vm.device.desktop = true;
      }

      window.addEventListener("resize", function(e) {
        let windowTarget = e.target,
          availableWidth = windowTarget.screen.availWidth,
          actualWidth = windowTarget.innerWidth,
          appBody = document.querySelector(".app-body");

        if (actualWidth < 768) {
          vm.device.mobile = true;
          vm.device.desktop = false;
        } else {
          vm.device.mobile = false;
          vm.device.desktop = true;
        }
      });
    },
    getHash() {
      let hash = window.location.hash;
      this.hash =
        "/" +
        hash
          .split("/")
          .splice(1, hash.split("/").length)
          .join("/");
    }
  },
  created() {
    // check device
    this.checkDeviceType();

    // update navigation active link when app loads
    this.getHash();
  }
};
</script>
<style lang="scss" scoped>
.nav-container {
  position: relative;
}

.dropdown-toggle {
  &::after {
    position: relative;
    top: 11px;
    float: right;
  }
}

.topbar-nav-links {
  position: relative;
  top: 7px;

  li {
    display: inline-flex;
    padding: 0 10px;
  }
}

.topbar {
  position: absolute;
  width: 100%;
  min-height: 60px;
  z-index: 2;
  background-color: #fff;
  // box-shadow: 140px 0 5px #e5e5e5;
  // border-bottom: 1px solid #e5e5e5;
}

.topbar-mobile {
  position: absolute;
  z-index: 2;
  background-color: #fff;
}

.sidebar {
  position: absolute;
  width: 203px;
  // padding: 15px;
  height: 100vh;
  align-items: start;
  z-index: 100;
  background-color: #fcfcfc;
  // box-shadow: 0 60px 5px #e5e5e5;
  // border-right: 1px solid #e5e5e5;
  transition: all 0.3s ease-in-out;

  .brand {
    height: 61px;
    border-bottom: 1px solid #e5e5e5;
    // border-right: 1px solid #e5e5e5;
  }

  li {
    padding: 15px 0px;
    position: relative;
    // border-top: 1px solid #e5e5e5;
    border-bottom: 1px solid darken(#fcfcfc, 4%);
    transition: all 8s ease-in-out;

    a {
      padding-left: 15px;
    }

    .active-link {
      border: 1px solid #e5e5e5;
      background-color: #28A745;
      position: absolute;
      height: 100%;
      left: 0;
      top: 0;
      width: 10px;
      transition: all 8s ease-in-out;
    }
  }
}

// .sidebar-links {
//   // border: 1px solid red;
// }

.expanded-color {
  color: forestgreen !important;
}

.expanded {
  width: 250px;

  li {
    text-align: left !important;
  }
}

.menu-width-toggle {
  position: absolute;
  top: 95%;
  left: 0;
  text-align: center;
  font-size: 1.5em;
  transition: all 0.3s ease-in-out;

  @media screen and (min-width: 992px) {
    top: 92%;
  }
}

.sidebar-mobile {
  position: absolute;
  padding-top: 70px;
  padding-left: 15px;
  height: 100vh;
  align-items: start;
  z-index: 1;
  background-color: #fff;
  transition: all 0.3s ease-in-out;
  overflow: hidden;

  li {
    padding: 10px 0;
  }
}

.sidebar-closed {
  left: -15px;
  width: 0;
  opacity: 0;
}

.sidebar-open {
  left: 0px;
  width: 250px;
  // box-shadow: 0 0 10px #e5e5e5;
  opacity: 1;
}
</style>

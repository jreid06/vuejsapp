import Vue from 'vue';
// import {router} from './../main.js';
import Vuex from 'vuex';
import register from './modules/register_user';
import login from './modules/logged_inuser';


Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    pathname: 'http://footballformations.vue',
    globalHref: '#',
    ajaxSettings: {
      init: false,
      ajax: ''
    },
    accountTypes: [],
  },
  getters: {
    getPackageInfo: (state) => (accountType) => {
      let accountTypes = state.accountTypes,
        packageInfo = [];

      console.log('getPackageInfo getter has been run');

      accountTypes.forEach(function (v, index) {
        console.log(index);
        console.log(v);
        switch (accountType) {
          case 'manager':
            if (v.account_name.toLowerCase() === accountType) {
              for (let i = 0; i < v.account_packages.data.length; i++) {
                const element = v.account_packages.data[i].data;

                console.log('CASE MANAGER HERE!!!!*****!!!');

                console.log(v.account_packages.data[i]);


                // parse the package description if it needs to be
                try {
                  element.package_description = JSON.parse(element.package_description);

                  element.player_stats = JSON.parse(element.player_stats);
                  element.team_stats = JSON.parse(element.team_stats);

                } catch (e) {

                }


                packageInfo.push(element);

                console.log(element);

              }
            }
            break;
          case 'player':
            if (v.account_name.toLowerCase() === accountType) {
              for (let i = 0; i < v.account_packages.data.length; i++) {
                const element = v.account_packages.data[i].data;

                // parse the package description
                try {
                  element.package_description = JSON.parse(element.package_description);

                  element.player_stats = JSON.parse(element.player_stats);

                } catch (e) {

                }

                packageInfo.push(element);
              }
            }
            break;

          default:
            break;
        }
      });

      return packageInfo;
    }
  },
  mutations: {
    directUser: (state, payload) => {
      switch (payload) {
        case '/join/manager/':

          break;

        default:
          break;
      }
    },
    checkAuth: (state, payload) => {
      // console.log('check auth has been invoked() GLOBAL');
      // console.log($('meta[name="csrf-token"]').attr('content'));

      const sm = this;
      let tokenSet = $('meta[name="csrf-token"]').attr('content') ? $('meta[name="csrf-token"]').attr('content') : false;


      $.ajax({
        dataType: "json",
        type: 'post',
        url: '/scripts/check_session.php',
        success(response) {
          console.log("CHECK SESSION RESPONSE");

          console.log(response);

          switch (response.status.code) {
            case 300:
              // user not logged in 
              $('meta[name="csrf-token"]').attr('content', response.info.csrftoken);

              // set store logged in data csrf token and status
              state.login_module.loggedInData.csrftoken.status = true;
              state.login_module.loggedInData.csrftoken.token = response.info.csrftoken;

              let register_module_init = store.getters.returnRegisterStatus,
                login_module_init = store.getters.returnLoginStatus;

              if (!register_module_init && payload.to.meta.register_status) {
                store.commit('initRegister');
                console.log("CHECK ACCOUNT & PACKAGE DETAILS: " + store.getters.checkAccountPackageDetails);

                if (store.getters.returnRegisterStatus && store.getters.checkAccountPackageDetails) {
                  console.log(' ');
                  console.log(' ');

                  console.log("STATUS TRUE FOR REG & ACC/PACK");

                  payload.next();
                  break;
                }

                console.log('RETURN USER TO REGISTER PAGE');

                payload.next('/register');

                break;
              }

              if (payload.to.meta.loggedInUsersOnly) {
                if (login_module_init) {
                  payload.next();
                  break;
                } else {

                  payload.next('/login');

                  break;
                }
              }

              console.log('GO TO NEXT DEFAULT');

              payload.next();

              break;
            case 200:
              // user is logged in 
              $('meta[name="csrf-token"]').attr('content', response.info.csrftoken);

              console.log("CHECK AUTH CASE LOGGED IN");
              console.log(response);

              // update logged in user data 
              store.dispatch('updateSession', response.info);


              if (payload.to.meta.hasOwnProperty('loginAccess') && !payload.to.meta.loginAccess) {

                console.log('REDIRECT TO DASHBOARD');
                console.log(payload.to.meta.loginAccess);


                // redirect user back to the dashboard
                payload.next(`/app/dashboard/home/${store.getters.returnUserIDs.account_id}`);
                break;
              }

              // go to whatever the intended route was
              payload.next();

              console.log('TRUE 200');
              // next('/');
              // resolve(response);
              break;
            default:
              break;
          }

        },
        error() {

        }
      });


    },
    setupAjax: state => {
      const vm = this;
      let csrftokenSet = $('meta[name="csrf-token"]').attr('content') ? $('meta[name="csrf-token"]').attr('content') : false;

      if (!state.ajaxSettings.init || !state.ajaxSettings.ajax.headers.CsrfToken) {
        console.log('AJAX IS BEING SETUP');

        let setup = $.ajaxSetup({
          dataType: "json",
          headers: {
            'CsrfToken': csrftokenSet ? csrftokenSet : false,
          }
        });

        // set the ajax setup variable to true. INIT success
        state.ajaxSettings.init = true;
        state.ajaxSettings.ajax = setup;

        return false;
      } else {
        console.log('AJAX IS ALREADY SETUP');
      }

      return true;

    },
    setAccountTypes: state => {
      const vm = this;

      if (state.route.path === "/register" && state.accountTypes.length <= 0) {
        console.log("GET ACCOUNT TYPES FROM $ajax");
        $.ajax({
          dataType: "json",
          url: "/scripts/frontend.php",
          type: "post",
          data: {
            frontend_data_key: "get_account_type"
          },
          success: function (response) {
            console.log(response);

            // add the account types to vuex store
            // mutations.commit("updateAccountTypes", response.info.data);

            // register the accountTypes $store variable with the data
            for (let i = 0; i < response.info.data.length; i++) {
              const element = response.info.data[i];

              if (response.info.data[i].metadata == null) {
                state.accountTypes.push(response.info.data[i].data);
                continue;
              }

              // only runs if metadata is used in data pulled from db
              state.accountTypes.push(response.info.data[i]);
            }
          },
          error: function () {
            // TODO: create error class that will update error database log
            alert("error getting account types");
          }
        });
      }

      console.log('account data exists');

    },
    updateAccountTypes: (state, account_types) => {
      if (Array.isArray(account_types)) {
        for (let i = 0; i < account_types.length; i++) {
          const element = account_types[i];

          console.log(element);
          state.accountTypes.push(element.data);
          console.log(state.accountTypes);

        }
      }

      console.log(state);

    }
  },
  modules: {
    register_module: register,
    login_module: login
  }

})

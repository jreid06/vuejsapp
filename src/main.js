import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import { sync } from 'vuex-router-sync'
import {store} from './store/store'
import {
  routes
} from './routes';


// Register the plugin
Vue.use(VueRouter);

// export router to be used in other files 
export const router = new VueRouter({
  routes: routes
});

// sync router variables to store
sync(store, router);

Vue.directive('highlight', {
  bind(el, binding, vnode) {

    // working with modifier
    let delay = 0;
    if (binding.modifiers['delayed']) {
      delay = 3000;
    }

    // el.style.backgroundColor = 'green';

    // working with the user input if property is reactive e.g ="reactiveData"
    // el.style.backgroundColor = binding.value;

    //working with arguments

    setTimeout(function () {
      if (binding.arg == 'background') {
        el.style.backgroundColor = binding.value;
      } else {
        el.style.color = binding.value;
      }
    }, delay);


  }
})

Vue.directive('focus', {
  // When the bound element is inserted into the DOM...
  inserted: function (el) {
    // Focus the element
    el.focus()
  }
})

// router global navguards

router.beforeEach(function (to, from, next) {
  if(!store.state.ajaxSettings.init || !store.state.ajaxSettings.ajax.headers.CsrfToken){
    store.commit("setupAjax");
  }else{
    console.log('ajax has been set up already');
  }
 
  if (to.meta.checkAuth) {      
     store.commit('checkAuth', {next: next, to: to});
    
  } else {
    // go to the requested path as no authentication checks are needed
    next();
  }
})

export const eventBus = new Vue();

new Vue({
  el: '#app',
  store: store,
  router: router,
  render: h => h(App)
})

import Home from './components/frontend/Home.vue'
import Loginregister from './components/frontend/loginregister/Loginregister.vue'
import Packages from './components/frontend/loginregister/Packages.vue'
import Packagelist from './components/frontend/packagelistings/Packagelist.vue'
import Signup from './components/frontend/loginregister/Signup.vue'

//////////////////////////
// App components below
//////////////////////////
import DashboardMain from './components/formationsapp/Dashboardhome.vue'
import DashboardHome from './components/formationsapp/Dashboard.vue'


// dummy components
import Test1 from './components/frontend/dummycomponents/Test.vue';
import Test2 from './components/frontend/dummycomponents/Test2.vue';

export const routes = [{
    path: '/',
    component: Home,
    meta: {
      checkAuth: true,
      loginAccess: true
    }
  },
  {
    path: '/login',
    component: Loginregister,
    meta: {
      checkAuth: true,
      loginAccess: false
    }
  },
  {
    path: '/register',
    component: Loginregister,
    meta: {
      checkAuth: true,
      loginAccess: false
    }
  },
  {
    path: '/join/:account_type/packages',
    component: Packages,
    meta: {
      checkAuth: true,
      register_status: true,
      loginAccess: false
    },
  },
  {
    path: '/join/:account_type/packages/:package_name',
    component: Packagelist,
    meta: {
      checkAuth: true,
      loginAccess: false
    }
  },
  {
    path: '/signup/:account_type/:package_name',
    component: Signup,
    meta: {
      checkAuth: true,
      register_status: true,
      loginAccess: false
    }
  },
  {
    path: '/app/dashboard/home',
    component: DashboardMain,
    meta: {
      checkAuth: true,
      loggedInUsersOnly: true
    },
    children: [{
        path: '/app/dashboard/home/:user_id',
        component: DashboardHome,
        meta: {
          checkAuth: true,
          loggedInUsersOnly: true
        }
      },
      {
        path: '/app/teams/all/:user_id',
        component: Test1,
        meta: {
          checkAuth: true,
          loggedInUsersOnly: true
        }
      }
    ]
  },
  {
    path: "*",
    redirect: "/"
  }
];

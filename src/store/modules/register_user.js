const state = {
  register: {
    status: false,
    user_details: {
      account_type_id: '',
      package_id: '',
      first_name: '',
      last_name: '',
      email: '',
      password: ''
    },
    package_details: '',
    account_details: ''
  }
}

const getters = {
  checkAccountPackageDetails(){
    if(state.register.package_details !== '' && state.register.account_details !== '') return true;

    return false;
  },
  returnUserDetails: state => {
      return state.register.user_details;
  },
  returnAccountDetails: state => {
    return state.register.account_details;
  },
  returnAccountName: state => {
    return state.register.account_details.account_name;
  },
  returnPackageDetails: state => {
    return state.register.package_details;
  },
  returnRegisterStatus: state => {
    return state.register.status;
  }
}

const mutations = {
  initRegister: state => {
    !state.register.status ? state.register.status = true : '';
  },
  updateUserDetails: (state, payload) => {

    if (state.register.status) {
      for (const key in payload) {
        if (state.register.user_details.hasOwnProperty(key)) {
          // update the store user details
          state.register.user_details[key] = payload[key];

        }else{

          // updates package_details & account_details if they are set in the state
          if(state.register.hasOwnProperty(key)){
            state.register[key] = payload[key];
          }
        }
      }

    }

    return;

  }
}

const actions = {

}

export default {
  state,
  getters,
  mutations,
  actions
}

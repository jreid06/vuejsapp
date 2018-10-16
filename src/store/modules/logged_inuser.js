import {
  resolve
} from "url";

const state = {
  loggedInData: {
    status: false,
    csrftoken: {
      status: false,
      token: ''
    },
    session: {
      authToken: '',
      status: false
    },
    user: '',
    widgets: {
      teams_data: []
    }
  }
}

const getters = {
  returnLoginStatus: state => {
    return state.loggedInData.status;
  },
  returnUserName: state => {
    return state.loggedInData.user.account_holder_full_name
  },
  returnUserObject: state => {
    return state.loggedInData.user;
  },
  returnPackageInfo: state => {
    return state.loggedInData.user.selected__package;
  },  
  returnUserIDs: state => {
    return {
      account_id: state.loggedInData.user.account_id_code,
      id: state.loggedInData.user.id
    };
  },
  returnLoginHistory: state => {
    return state.loggedInData.user.login_history_json;
  },
  returnTeamsData: (state, data) => {
    if (data.status) {
      let d = state.loggedInData.user.managers_teams;
      d.data.filter(function(el,i){
        if(data.arg === el.id){
          return el;
        }
       });
    }

    return state.loggedInData.user.managers_teams;
  },
  returnTeamsTotal: state => {
    // return state.loggedInData.user.managers_teams.hasOwnProperty('data') ? state.loggedInData.user.managers_teams.data.length : 0;
  },
  returnWidgetTeamsData: state => {
    return state.loggedInData.widgets.teams_data;
  }
}

const mutations = {
  updateSession: (state, payload) => {
    let sessionData = payload;

    console.log('UPDATE session');

    console.log(sessionData);

    // update authToken
    if (sessionData.session.hasOwnProperty('authToken')) state.loggedInData.session.authToken = sessionData.session.authToken;

    // set the session status to true
    state.loggedInData.session.status = true;

    // set loggindata status main to true
    state.loggedInData.status = true;

    // update user object with logged in user details
    if (sessionData.hasOwnProperty('user')) state.loggedInData.user = sessionData.user.data;

  },
  clearSessionData: (state) => {
    let loggedInData_ = state.loggedInData;

    for (const k in loggedInData_) {
      if (loggedInData_.hasOwnProperty(k)) {
        if (typeof loggedInData_[k] === 'object') {
          for (const ik in loggedInData_[k]) {
            loggedInData_[k][ik] = '';
          }
          continue;
        }
        loggedInData_[k] = '';
      }
    }

    return;
  },
  addFileData: (state, dataObj) => {
    let file_uploads = state.loggedInData.user.file_uploads.data,
      $data = dataObj.dataArray.data,
      $key = dataObj.key,
      vm = this;

    if (state.loggedInData.widgets.teams_data.length > 0) {
      // reset array to empty so we dont get duplicates
      state.loggedInData.widgets.teams_data = [];
    }

    if (typeof state.loggedInData.widgets.teams_data !== 'array') state.loggedInData.widgets.teams_data = [];

    for (let i = 0; i < $data.length; i++) {
      const el = $data[i].data;
      for (let f = 0; f < file_uploads.length; f++) {
        const file = file_uploads[f].data;
        if (el[$key] === file.id) {
          if (!el.hasOwnProperty('file_name')) {
            el['file_name'] = file.url;
          }
        }
      }

      // add data to teams widget array
      state.loggedInData.widgets.teams_data.push(el);
    }

  }
}

const actions = {
  updateSession({
    commit
  }, payload) {
    console.log('UPDATE SESSION ACTION');
    // console.log(payload);
    commit('updateSession', payload);
  }
}

export default {
  state,
  getters,
  mutations,
  actions
}

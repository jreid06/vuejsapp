import {router} from './../main';
const Joi = require("joi-browser");

export const globalMixin = {
  data() {
    return {
      joi_schema: '',
      backend_config: {
        url: 'admin.footballformations.vue',
        http: 'http://'
      }

    }
  },
  methods: {
    routeChangeFunction(route){
      
    },
    getSessionStorage(){

    },
    setSessionStorage(){
      
    },
    redirectUser(router, path, timeout) {
      if (timeout.set) {
        setTimeout(function () {
          router.push({
            path: path
          });
        }, timeout.time);
      }

      router.push({
        path: path
      });

    },
    logout() {
      console.log("log me out please");
      const vm = this,
        runAjax = true;

      let user = JSON.parse(JSON.stringify(vm.$store.getters.returnUserObject));

      if (!runAjax) {
        return;
      }

      $.post("/scripts/logout.php", {
        user: user
      }, response => {
        console.log('LOGOUT RESPONSE BELOW');

        console.log(response);

        switch (response.status.code) {
          case 200:

            // reset values in the login module
            vm.$store.commit('clearSessionData');

            router.push({
              path: response.info.redirect
            });

            break;
          case 400:

            router.push({
              path: response.info.redirect
            });

            break;
        }

      }).fail(error => {
        alert('Error logging out. Try again');
      });
    },
    returnJSON(json) {
      let result = '';
      try {
        result = JSON.parse(json);

        return result;
      } catch (error) {
        // update error log 
        return false;
      }
    },
    setJoiRegisterSchema() {
      this.joi_schema = '';

      //
      this.joi_schema = Joi.object().keys({
        email: Joi.string().email(),
        first_name: Joi.string().required(),
        last_name: Joi.string().required(),
        account_id: Joi.number().integer().min(0),
        package_id: Joi.number().integer().min(0),
        // NOTE: regex Upper & lower A-Z - all digits -  min len 3 max 30
        password: Joi.string().regex(/^[a-zA-Z0-9]{3,30}$/).required(),
      });
    },
    setJoiLoginSchema() {
      this.joi_schema = '';

      //
      this.joi_schema = Joi.object().keys({
        email: Joi.string().email().required(),
        // NOTE: regex Upper & lower A-Z - all digits -  min len 3 max 30
        password: Joi.string().regex(/^[a-zA-Z0-9]{3,30}$/).required(),
      });
    },
    JOI_registerValidate(formdata) {
      this.setJoiRegisterSchema();
      const schema = this.joi_schema;

      //validate form data against the schema
      const result = Joi.validate({
          email: formdata.email,
          password: formdata.password,
          first_name: formdata.first_name,
          last_name: formdata.last_name,
          account_id: formdata.account_type_data.id,
          package_id: formdata.package_data.id
        },
        schema
      );

      return result;

    },
    JOI_loginValidate(formdata) {
      this.setJoiLoginSchema();
      const schema = this.joi_schema;

      const result = Joi.validate({
          email: formdata.email,
          password: formdata.password
        },
        schema
      );

      return result;
    }
  }
}

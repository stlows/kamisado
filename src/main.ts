import Vue from "vue";
import Vuex from "vuex";
import BootstrapVue from "bootstrap-vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

axios.defaults.baseURL = "https://kamisado-40f99.firebaseio.com/";

Vue.config.productionTip = false;

Vue.use(BootstrapVue);
Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    notifications: [] as any
  },
  mutations: {
    notify(state, _notification) {
      let notification = {
        message: _notification.message,
        variant:
          typeof _notification.variant === "undefined"
            ? "info"
            : _notification.variant,
        id: "notification" + Date.now()
      };
      state.notifications.push(notification);
    }
  }
})

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");

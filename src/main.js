import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import axios from "axios";

axios.defaults.baseURL = "https://kamisado-40f99.firebaseio.com/";

Vue.config.productionTip = false;

import { store } from "./store.js";
import vuetify from './plugins/vuetify';

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount("#app");

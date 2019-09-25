import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("./views/Home.vue")
    },
    {
      path: "/local/lobby",
      name: "local/lobby",
      component: () => import("./views/LocalLobby.vue")
    },
    {
      path: "/newGame",
      name: "newGame",
      component: () => import("./views/NewGame.vue")
    },
    {
      path: "/local/game",
      name: "local/game",
      component: () => import("./views/LocalGame.vue"),
      props: true
    },
    {
      path: "/online/game/:id",
      name: "online/game",
      component: () => import("./views/OnlineGame.vue"),
      props: true
    }
  ]
});

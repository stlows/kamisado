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
      path: "/online/lobby",
      name: "online/lobby",
      component: () => import("./views/OnlineLobby.vue")
    },
    {
      path: "/myGames",
      name: "myGames",
      component: () => import("./views/MyGames.vue")
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
    },
    {
      path: "/online/game",
      name: "online/game",
      component: () => import("./views/OnlineGame.vue"),
      props: true
    },
    {
      path: "/register",
      name: "register",
      component: () => import("./views/Register.vue")
    },
    {
      path: "/verify/:username",
      component: () => import("./views/Verify.vue"),
      props: true
    },
    {
      path: "/login",
      name: "login",
      component: () => import("./views/Login.vue")
    },
  ]
});

import Vue from "vue";
import Vuex from "vuex";
import Notification from "./models/Notification";
import Game from "./models/Game";

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    notifications: [] as Notification[],
    loginAs: "cprovost",
    localGames: [] as Game[]
  },
  mutations: {
    notify(state: any, notification: Notification) {
      state.notifications.push(notification);
    },
    updateLogin(state: any, updatedLogin: string) {
      state.loginAs = updatedLogin;
    },
    addLocalGame(state: any, game: Game) {
      state.localGames.push(game);
    }
  },
  getters: {
    gameById: (state: any) => (id: number) => {
      return state.localGames.find((g: Game) => g.id === id);
    }
  }
});

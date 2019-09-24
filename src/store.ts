import Vue from "vue";
import Vuex from "vuex";
import Notification from "./models/Notification"
import Game from './models/Game';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
      notifications : [] as Notification[],
      loginAs: "cprovost",
      localGames: [] as Game[]
    },
    mutations: {
      notify(state, notification : Notification) {
        state.notifications.push(notification);
      },
      updateLogin(state, updatedLogin){
        state.loginAs = updatedLogin;
      },
      addLocalGame(state, game){
        state.localGames.push(game);
      }
    },
    getters: {
      gameById : (state) => (id : number) => {
        return state.localGames.find((g:Game)  => g.id === id)
      }
    }
  })
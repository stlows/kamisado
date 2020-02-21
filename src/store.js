import Vue from "vue";
import Vuex from "vuex";
import Notification from "./models/Notification";
import Game from "./models/Game";
import { api } from "./plugins/api"

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    notifications: [],
    token: "",
    localGames: [],
  },
  mutations: {

    setToken(state, token) {
      state.token = token;
    },
    addLocalGame(state, game) {
      state.localGames.push(game);
    }
  },
  actions: {
    notify({ commit, state }, notification) {
      state.notifications.push(notification);
    },
    newGame({ commit, state }, lobbyId) {
      return api.post("new-game.php", { lobbyId }, {
        headers: {
          'Authorization': state.token
        }
      })
    },
    getGame({ commit, state }, gameId) {
      return api.get("game.php?gameId=" + gameId, {
        headers: {
          'Authorization': state.token
        }
      })
    },
    getMyGames({ commit, state }, ) {
      return api.get("my-games.php", {
        headers: {
          'Authorization': state.token
        }
      })
    },
    getTiles({ commit, state }, ) {
      return api.get("tiles.php", {
        headers: {
          'Authorization': state.token
        }
      })
    },
    getLobby({ commit, state }, ) {
      return api.get("lobby.php", {
        headers: {
          'Authorization': state.token
        }
      })
    },
    newLobby({ commit, state }, pointsToWin) {
      return api.post("new-lobby.php", { pointsToWin }, {
        headers: {
          'Authorization': state.token
        }
      })
    },
    deleteLobby({ commit, state }, lobbyId) {
      return api.post("delete-lobby.php", { lobbyId }, {
        headers: {
          'Authorization': state.token
        }
      })
    },
    move({ commit, state }, game){
      return api.post("move.php", game, {
        headers: {
          'Authorization': state.token
        }
      })
    }
  },
  getters: {
    gameById: (state) => (id) => {
      return state.localGames.find((g) => g.id === id);
    },
    getToken(state) {
      return state.token
    }
  }
});

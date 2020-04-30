import Vue from "vue";
import Vuex from "vuex";
import { api } from "./plugins/api"

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    notifications: [],
    localGames: [],
    isSignedIn: false
  },
  mutations: {
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
          'Authorization': localStorage.get('token')
        }
      })
    },
    getGame({ commit, state }, gameId) {
      return api.get("game.php", {
        headers: {
          'Authorization': localStorage.get('token')
        },
        params: {
          gameId: gameId
        }
      })
    },
    getTower({ commit, state }, towerId) {
      return api.get("tower.php", {
        headers: {
          'Authorization': localStorage.get('token')
        },
        params: {
          towerId: towerId
        }
      })
    },
    getMyGames({ commit, state }, ) {
      return api.get("my-games.php", {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    getTiles({ commit, state }, ) {
      return api.get("tiles.php", {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    getLobby({ commit, state }, ) {
      return api.get("lobby.php", {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    newLobby({ commit, state }, pointsToWin) {
      return api.post("new-lobby.php", { pointsToWin }, {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    deleteLobby({ commit, state }, lobbyId) {
      return api.post("delete-lobby.php", { lobbyId }, {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    move({ commit, state }, move) {
      return api.post("move.php", move, {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    forfeit({ commit, state }, gameId) {
      return api.post("forfeit.php", { gameId: parseInt(gameId) }, {
        headers: {
          'Authorization': localStorage.get('token')
        }
      })
    },
    register({ commit, state }, credentials) {
      return api.post("register.php", credentials)
    },
    verify({ commit, state }, credentials) {
      return api.post("verify.php", credentials)
    },
    login({ commit, state }, credentials) {
      return api.post("login.php", credentials)
    },
    checkIsSignedIn({ state }) {
      state.isSignedIn = localStorage.getItem("token") !== null
    }
  },
  getters: {
    isSignedIn(state) {
      return state.isSignedIn
    }
  }
});

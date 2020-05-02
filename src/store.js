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
      notification.value = true
      notification.id = new Date().valueOf()
      state.notifications.push(notification);
    },
    newGame({ commit, state, getters }, lobbyId) {
      return api.post("new-game.php", { lobbyId }, getters.getHeaders)
    },
    getGame({ commit, state, getters }, gameId) {
      return api.get("game.php", {
        ...getters.getHeaders,
        params: {
          gameId: gameId
        }
      })
    },
    getTower({ commit, state, getters }, towerId) {
      return api.get("tower.php", {
        ...getters.getHeaders,
        params: {
          towerId: towerId
        }
      })
    },
    getMyGames({ commit, state, getters }, ) {
      return api.get("my-games.php", getters.getHeaders)
    },
    getTiles({ commit, state }, ) {
      return api.get("tiles.php")
    },
    getLobby({ commit, state, getters }, ) {
      return api.get("lobby.php", getters.getHeaders)
    },
    newLobby({ commit, state, getters }, pointsToWin) {
      return api.post("new-lobby.php", { pointsToWin }, getters.getHeaders)
    },
    deleteLobby({ commit, state, getters }, lobbyId) {
      return api.post("delete-lobby.php", { lobbyId }, getters.getHeaders)
    },
    move({ commit, state, getters }, move) {
      return api.post("move.php", move, getters.getHeaders)
    },
    forfeit({ commit, state, getters }, gameId) {
      return api.post("forfeit.php", { gameId: parseInt(gameId) }, getters.getHeaders)
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
    },
    getHeaders(state) {
      console.log(localStorage)
      return {
        headers: {
          'Authorization': 'Basic ' + localStorage.getItem('token')
        }
      }
    }
  }
});

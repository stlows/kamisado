import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
      notifications: [] as any,
      loginAs: "cprovost",
      localGames: [] as any,
      activeId: -1
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
      },
      updateLogin(state, updatedLogin){
        state.loginAs = updatedLogin;
      },
      addLocalGame(state, game){
        state.localGames.push(game);
      },
      loadLocalGame(state, id){
        state.activeId = id;
        console.log(id);
      }      
    },
    getters: {
      activeGame(state){
        return state.localGames.find((g:any)  => g.id === state.activeId)
      }
    }
  })
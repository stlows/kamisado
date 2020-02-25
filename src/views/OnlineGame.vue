<template>
  <div class="main">
    <div class="left">
      <OnlineLobby ref="onlineLobbyRef" @lobbyJoined="fetchGame" />
      <NewGame @refreshLobby="$refs.onlineLobbyRef.refreshLobby()" />
    </div>
    <div class="center">
      <div class="text-center mb-3">
        <a href="#" @click.prevent="forfeit(gameId)">Forfeit</a> |
        <a href="#" @click.prevent="fetchGame">Refresh</a>
      </div>
      <Board :towers="game.towers" @towerMoved="towerMoved"></Board>
    </div>
    <div class="right">
      <MyGames @refreshGame="fetchGame" />
    </div>
  </div>
</template>

<script>
import Board from "../components/Board";
import OnlineLobby from "./OnlineLobby";
import NewGame from "./NewGame";
import MyGames from "./MyGames";
import { mapActions } from "vuex";

export default {
  components: {
    OnlineLobby,
    NewGame,
    MyGames,
    Board
  },
  data() {
    return {
      game: {}
    };
  },
  methods: {
    ...mapActions(["getGame", "notify", "move", "forfeit"]),
    fetchGame() {
      this.game = {};
      this.getGame(this.gameId).then(res => {
        if (res.data.error) {
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
        } else {
          this.game = res.data;
        }
      });
    },
    towerMoved(tower) {
      this.move({
        towerId: tower.tower_id,
        target: {
          x: tower.position_x,
          y: tower.position_y
        }
      }).then(res => {
        if (res.data.valid) {
          return;
        } else {
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
          this.fetchGame();
        }
      });
    }
  },
  computed: {
    gameId() {
      return this.$route.params.id;
    }
  },
  created() {
    this.fetchGame();
  }
};
</script>

<style>
.main {
  padding: 30px;
  display: flex;
}
.left {
  width: 500px;
}
.center {
  margin: 0 50px;
}
.right {
  width: 900px;
}
</style>
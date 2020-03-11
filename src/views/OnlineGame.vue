<template>
  <div class="main">
    <div class="left">
      <OnlineLobby ref="onlineLobbyRef" @lobbyJoined="lobbyJoined" />
      <NewGame @refreshLobby="$refs.onlineLobbyRef.refreshLobby()" />
    </div>
    <div class="center">
      <div class="text-center mb-2">
        <a href="#" @click.prevent="forfeitGame">Forfeit</a> |
        <a href="#" @click.prevent="fetchGame" id="refreshLink">Refresh</a> |
        <a href="#" @click.prevent="rotate = !rotate" id="refreshLink">Rotate</a>
      </div>
      <div v-if="towerToMove" class="mb-2">
        <span
          class="tower-description"
          :class="[towerToMove.player_color, towerToMove.tower_color]"
        >{{ towerToMove.symbol }}</span>
      </div>
      <div v-if="!towerToMove && game.game">Turn: {{ game.game.turn_color }}</div>
      <Scoreboard :game="game.game" />
      <Board
        :towers="game.towers"
        @towerMoved="towerMoved"
        :playgroundMode="playgroundMode"
        :rotate="rotate"
      ></Board>
    </div>
    <div class="right">
      <MyGames ref="myGames" @refreshGame="fetchGame" />
      <b-form-checkbox id="playgroundModeCheckbox" v-model="playgroundMode">Playground Mode</b-form-checkbox>
    </div>
  </div>
</template>

<script>
import Board from "../components/Board";
import Scoreboard from "../components/Scoreboard";
import OnlineLobby from "./OnlineLobby";
import NewGame from "./NewGame";
import MyGames from "./MyGames";
import { mapActions } from "vuex";

export default {
  components: {
    OnlineLobby,
    NewGame,
    MyGames,
    Board,
    Scoreboard
  },
  data() {
    return {
      game: {},
      towerToMove: null,
      playgroundMode: false,
      rotate: false
    };
  },
  methods: {
    ...mapActions(["getGame", "notify", "move", "forfeit", "getTower"]),
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
          this.fetchTowerToMove();
        }
      });
    },
    fetchTowerToMove() {
      if (this.game.game.tower_id_to_move) {
        this.getTower(this.game.game.tower_id_to_move).then(res => {
          this.towerToMove = res.data;
        });
      } else {
        this.towerToMove = null;
      }
    },
    towerMoved(tower) {
      this.move({
        towerId: parseInt(tower.tower_id),
        target: {
          x: parseInt(tower.position_x),
          y: parseInt(tower.position_y)
        }
      }).then(res => {
        if (res.data.valid) {
          if (res.data.round_won_by) {
            this.fetchGame();
          } else {
            this.game.game.tower_id_to_move = res.data.tower_id_to_move;
            this.fetchTowerToMove();
          }
        } else {
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
          this.fetchGame();
        }
      });
    },
    forfeitGame() {
      this.forfeit(this.gameId).then(res => {
        this.fetchGame();
        this.$refs.myGames.refreshGames();
      });
    },
    lobbyJoined() {
      this.fetchGame();
      this.$refs.myGames.refreshGames();
    }
  },
  computed: {
    gameId() {
      return this.$route.params.id;
    }
  },
  created() {
    this.fetchGame();
    var vue = this;
    document.addEventListener("keydown", function(event) {
      if (event.keyCode == 80) {
        vue.playgroundMode = !vue.playgroundMode;
      }
    });
  }
};
</script>

<style lang="scss">
@import "../assets/colors.scss";
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
.tower-description {
  display: inline-block;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 30px;
  line-height: 50px;
  text-align: center;
  border: 1px solid black;
  pointer-events: none;
  user-select: none;
  &.white {
    background-color: $player-white;
  }
  &.black {
    background-color: $player-black;
  }
  &.orange {
    color: $orange;
  }
  &.green {
    color: $green;
  }
  &.red {
    color: $red;
  }
  &.indigo {
    color: $indigo;
  }
  &.blue {
    color: $blue;
  }
  &.yellow {
    color: $yellow;
  }
  &.brown {
    color: $brown;
  }
  &.pink {
    color: $pink;
  }
}
</style>
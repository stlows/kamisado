<template>
  <div class="d-flex pa-12">
    <div>
      <OnlineLobby ref="onlineLobbyRef" @lobbyJoined="lobbyJoined" class="mb-12" />
      <NewGame @refreshLobby="$refs.onlineLobbyRef.refreshLobby()" />
    </div>
    <div class="mx-auto">
      <div class="d-flex">
        <div class="d-flex flex-column mr-6">
          <Board
            :towers="game.towers"
            @towerMoved="towerMoved"
            :playgroundMode="playgroundMode"
            :rotate="rotate"
          ></Board>
          <v-form class="text-center mx-auto" style="max-width: 250px">
            <v-checkbox label="Playground Mode" v-model="playgroundMode"></v-checkbox>
          </v-form>
        </div>
        <div class="d-flex flex-column align-center mt-8">
          <v-btn text color="info" @click.prevent="fetchGame" class="mb-3">Refresh</v-btn>
          <v-btn text color="warning" @click.prevent="forfeitGame" class="mb-3">Forfeit</v-btn>
          <v-btn icon text color="info" @click.prevent="rotate = !rotate" title="Rotate Board">
            <v-icon>mdi-rotate-3d-variant</v-icon>
          </v-btn>
        </div>
      </div>
    </div>
    <div class="right">
      <ActiveGameInfo :game="game.game" class="mb-12"></ActiveGameInfo>
      <MyGames ref="myGames" @refreshGame="fetchGame" />
    </div>
  </div>
</template>

<script>
import Board from "../components/Board";
import ActiveGameInfo from "../components/ActiveGameInfo";
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
    ActiveGameInfo
  },
  data() {
    return {
      game: {},
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
        }
      });
    },
    towerMoved(tower) {
      this.move({
        towerId: parseInt(tower.tower_id),
        target: {
          x: parseInt(tower.position_x),
          y: parseInt(tower.position_y)
        }
      })
        .then(res => {
          if (!res.data.valid) {
            this.notify({
              id: new Date().valueOf(),
              variant: "danger",
              message: res.data.message
            });
          }
        })
        .finally(() => {
          this.fetchGame();
          //this.$refs.myGames.refreshGames();
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

.tower-description {
  display: inline-block;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  font-size: 30px;
  line-height: 50px;
  text-align: center;
  border: 1px solid black;
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
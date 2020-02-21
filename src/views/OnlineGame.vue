<template>
  <div>
    <div class="text-center mb-3">
      <p>Game ID: {{gameId}}</p>
      <a href="#" @click.prevent="fetchGame">Refresh</a>
    </div>

    <Board :towers="game.towers" @towerMoved="towerMoved"></Board>
  </div>
</template>

<script>
import Board from "../components/Board";
import { mapActions } from "vuex";

export default {
  components: {
    Board
  },
  data() {
    return {
      game: {},
    };
  },
  methods: {
    ...mapActions(["getGame", "notify", "move"]),
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
    towerMoved(tower){
      this.move({
        gameId: this.gameId,
        tower: tower.tower_id,
        target: {
          x: tower.position_x,
          y: tower.position_y
        }
      }).then(res => {
        if(res.data.valid){
          return
        }else{
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
          this.fetchGame()
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
</style>
<template>
  <div>
    <div class="text-center mb-3">
      <p>Game ID: {{gameId}}</p>
      <button class="btn btn-primary text-center">Confirm</button>
    </div>

    <Board v-if="towers" :towers="towers"></Board>
    <template v-else>Loading...</template>
  </div>
</template>

<script>
import { newGame, getGame } from "../plugins/api.js";
import Board from "../components/Board";

export default {
  components: {
    Board
  },
  data() {
    return {
      towers: null
    };
  },
  computed: {
    gameId() {
      return this.$route.params.id;
    }
  },
  created() {
    getGame(this.gameId).then(res => {
      this.towers = res.data.towers;
    });
  }
};
</script>

<style>
</style>
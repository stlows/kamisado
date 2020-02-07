<template>
  <div>
    <div class="text-center mb-3">
      <p>Game ID: {{gameId}}</p>
      <a href="#" @click.prevent="fetchGame">Refresh</a>
    </div>

    <Board :towers="towers"></Board>
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
      towers: []
    };
  },
  methods: {
    ...mapActions(["getGame", "notify"]),
    fetchGame() {
      this.towers = [];
      this.getGame(this.gameId).then(res => {
        if (res.data.error) {
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
        } else {
          this.towers = res.data.towers;
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
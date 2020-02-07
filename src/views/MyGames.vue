<template>
  <div class="my-games">
    <div class="card games-container">
      <div class="card-header">
        <h3>My games</h3>
        <a href="#" @click="refreshGames">Refresh</a>
      </div>
      <div class="card-body">
        <template v-if="loading"></template>
        <template v-else>
          <template v-if="games.length > 0">
            <b-table :items="games" :fields="fields">
              <template v-slot:cell(game_id)="data">
                <a href="#" @click.prevent="goToGame(data)">Go to game</a>
              </template>
            </b-table>
          </template>
          <template v-else>
            <p>Head to the lobby!</p>
          </template>
        </template>
      </div>
    </div>
  </div>
</template>


<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      fields: [
        "player_1_name",
        "player_2_name",
        "points_to_win",
        "player_1_score",
        "player_2_score",
        { key: "game_id", label: "Link" }
      ],
      games: [],
      loading: true
    };
  },
  methods: {
    ...mapActions(["getMyGames"]),
    refreshGames() {
      this.loading = true;
      this.getMyGames().then(res => {
        this.games = res.data;
        this.loading = false;
      });
    },
    goToGame(data) {
      this.$router.push({ path: "/online/game/" + parseInt(data.value) });
    }
  },
  created() {
    this.refreshGames();
  }
};
</script>

<style>
.games-container {
  max-width: 1000px;
  margin: 50px auto;
}
</style>


<template>
  <v-card class="pa-6">
    <div class="d-flex justify-space-between mb-3">
      <h2>My games</h2>
      <v-spacer></v-spacer>
      <v-btn @click.prevent="refreshGames" color="info" text>Refresh</v-btn>
    </div>
    <template v-if="games.length > 0">
      <v-data-table :items="games" :headers="headers" disable-sort>
        <template v-slot:item.game_id="{ item }">
          <v-btn text color="success" @click="goToGame(item.game_id)">Go</v-btn>
        </template>
      </v-data-table>
    </template>
    <template v-else>
      <p>Join a game in the lobby!</p>
    </template>
  </v-card>
</template>


<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      headers: [
        { value: "rival_name", text: "Vs." },
        { value: "points_to_win", text: "To win" },
        { value: "your_score", text: "Your score" },
        { value: "rival_score", text: "Rival score" },
        { value: "game_id", text: "Go" }
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
    goToGame(game_id) {
      this.$router.push({ path: "/online/game/" + parseInt(game_id) });
      this.$emit("refreshGame");
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


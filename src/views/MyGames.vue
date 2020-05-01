<template>
  <v-card class="pa-6">
    <div class="d-flex justify-space-between">
      <h2>My games</h2>
      <v-spacer></v-spacer>
      <v-btn @click.prevent="refreshGames" color="info" text>Refresh</v-btn>
    </div>
    <div class="card-body">
      <template v-if="loading"></template>
      <template v-else>
        <template v-if="games.length > 0">
          <v-data-table :items="games" :headers="fields">
            <template v-slot:cell(game_id)="data">
              <a href="#" @click.prevent="goToGame(data)">Go to game</a>
            </template>
          </v-data-table>
        </template>
        <template v-else>
          <p>Join a game in the lobby!</p>
        </template>
      </template>
    </div>
  </v-card>
</template>


<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      fields: [
        { key: "rival_name", label: "Vs." },
        { key: "points_to_win", label: "To win" },
        "your_score",
        "rival_score",
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


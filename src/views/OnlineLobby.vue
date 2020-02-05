<template>
  <div class="lobby">
    <div class="card games-container">
      <div class="card-header">
        <h3>Lobby</h3>
        <a href="#" @click="refreshLobby">Refresh</a>
      </div>
      <div class="card-body">
        <template v-if="loading"></template>
        <template v-else>
          <template v-if="games.length > 0">
            <b-table :items="games" :fields="fields">
              <template v-slot:cell(lobby_id)="data">
                <a href="#" @click.prevent="goToGame(data)">Join</a>
              </template>
            </b-table>
          </template>
          <template v-else>
            <p>No games yet...</p>
          </template>
        </template>
      </div>
      <div class="card-footer">
        <button class="btn btn-large btn-primary" @click="newGame">New Game</button>
      </div>
    </div>
  </div>
</template>


<script>
import { Component, Vue } from "vue-property-decorator";
import { getLobby, newGame, deleteLobby } from "../plugins/api";

export default {
  data() {
    return {
      fields: [
        "player_name",
        "points_to_win",
        { key: "lobby_id", label: "Link" }
      ],
      games: [],
      loading: true
    };
  },
  methods: {
    refreshLobby() {
      this.loading = true;
      getLobby().then(res => {
        this.games = res.data;
        this.loading = false;
      });
    },
    newGame() {
      this.$router.push({ path: "/newGame" });
    },
    goToGame(data) {
      newGame(parseInt(data.value)).then(res => {
        deleteLobby(parseInt(data.value));
        this.$router.push({ path: "/online/game/" + res.data });
      });
    }
  },
  created() {
    this.refreshLobby();
  }
};
</script>

<style>
.games-container {
  margin: 15px 20%;
}
</style>


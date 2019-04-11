<template>
  <div class="lobby">
    <h2>The Lobby</h2>
    <template v-if="games.length > 0">
      <div class="card games-container">
        <div class="card-header">
          <h3>Active games</h3>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item" v-for="game in games" :key="game">
              <a href="#" @click.prevent="goToGame(game)">Go to game {{game}}</a>
            </li>
          </ul>
        </div>
        <div class="card-footer">
          <button class="btn btn-large btn-primary" @click="newGame">New Game</button>
        </div>
      </div>
    </template>
    <template v-else>
      <p>No games yet...</p>
    </template>
  </div>
</template>

<script>
import { Component, Vue } from "vue-property-decorator";
import axios from "axios";

export default {
  data() {
    return {
      games: []
    };
  },
  methods: {
    newGame() {
      axios
        .post("games.json", {
          towers: [
            { playerId: 0, colorId: 0, x: 1, y: 1, sumo: 0 },
            { playerId: 0, colorId: 1, x: 2, y: 1, sumo: 0 },
            { playerId: 0, colorId: 2, x: 3, y: 1, sumo: 0 },
            { playerId: 0, colorId: 3, x: 4, y: 1, sumo: 0 },
            { playerId: 0, colorId: 4, x: 5, y: 1, sumo: 0 },
            { playerId: 0, colorId: 5, x: 6, y: 1, sumo: 0 },
            { playerId: 0, colorId: 6, x: 7, y: 1, sumo: 0 },
            { playerId: 0, colorId: 7, x: 8, y: 1, sumo: 0 },
            { playerId: 1, colorId: 7, x: 1, y: 8, sumo: 0 },
            { playerId: 1, colorId: 6, x: 2, y: 8, sumo: 0 },
            { playerId: 1, colorId: 5, x: 3, y: 8, sumo: 0 },
            { playerId: 1, colorId: 4, x: 4, y: 8, sumo: 0 },
            { playerId: 1, colorId: 3, x: 5, y: 8, sumo: 0 },
            { playerId: 1, colorId: 2, x: 6, y: 8, sumo: 0 },
            { playerId: 1, colorId: 1, x: 7, y: 8, sumo: 0 },
            { playerId: 1, colorId: 0, x: 8, y: 8, sumo: 0 }
          ],
          turn: 0,
          isFirstTurn: true,
          selectedTower: null,
          possibleMovesArray: []
        })
        .then(res => {
          this.$router.push("/game/" + res.data.name);
        });
    },
    goToGame(id) {
      this.$router.push({ path: "/game/" + id });
    }
  },
  created() {
    axios.get("games.json").then(res => {
      this.games = Object.keys(res.data);
    });
  }
};
</script>

<style>
.games-container {
  margin: 15px 20%;
}
</style>


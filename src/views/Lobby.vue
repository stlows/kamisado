<template>
  <div class="lobby">
    <div class="card games-container">
      <div class="card-header">
        <h3>Active games</h3>
      </div>
      <div class="card-body">
        <template v-if="games.length > 0">
          <div class="list-group">
            <div class="list-group-item" v-for="game in games" :key="game">
              <a href="#" @click.prevent="goToGame(game)">Go to game {{game}}</a>
            </div>
          </div>
        </template>
        <template v-else>
          <p>No games yet...</p>
        </template>
      </div>
      <div class="card-footer">
        <button class="btn btn-large btn-primary" @click="newGame">New Game</button>
      </div>
    </div>
  </div>
</template>

  </div>

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
          moveCounter: 0,
          selectedTower: null,
          possibleMovesArray: [],
          moves: []
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
      if (res.data) {
        this.games = Object.keys(res.data);
      }
    });
  }
};
</script>

<style>
.games-container {
  margin: 15px 20%;
}
</style>


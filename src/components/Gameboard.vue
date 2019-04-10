<template>
  <div>
    <table v-if="tileColors.length > 0">
      <tr v-for="y in 8" :key="'kamiRow_' + y">
        <td
          :class="{possible: possibleMovesArray !== null && isPossibleMove(x, y)}"
          v-for="x in 8"
          :key="'tile_' + x + '_' + y"
          :style="{ backgroundColor: getColor(tileColors[y-1][x-1]) }"
          @click="tileClicked(x, y)"
        >
          <app-tower
            @towerSelected="setSelectedTower"
            v-if="getTower(x,y) !== null"
            :tower="getTower(x,y)"
            :selected="selectedTower"
            :turn="turn"
            :isFirstTurn="isFirstTurn"
          ></app-tower>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import Tower from "./Tower.vue";
import axios from "axios";
import TileColors from "../assets/TileColors.json";
import Colors from "../assets/Colors.json";

export default {
  data() {
    return {
      tileColors: TileColors,
      towers: [],
      turn: 1,
      isFirstTurn: true,
      selectedTower: null,
      possibleMovesArray: []
    };
  },
  methods: {
    switchTurn() {
      if (this.turn === 1) this.turn = 0;
      else if (this.turn === 0) this.turn = 1;
      else console.error(id + " is invalid.");
    },
    getColor(id) {
      return Colors.tiles[id];
    },
    getTower(x, y) {
      let filter = this.towers.filter(t => t.x === x && t.y === y);
      if (filter.length === 1) return filter[0];
      else return null;
    },
    getTowerByPlayerIdAndColor(playerId, colorId) {
      let filter = this.towers.filter(
        t => t.playerId === playerId && t.colorId === colorId
      );
      if (filter.length === 1) return filter[0];
      else return null;
    },
    isPossibleMove(x, y) {
      for (let i in this.possibleMovesArray) {
        if (
          this.possibleMovesArray[i].x === x &&
          this.possibleMovesArray[i].y === y
        ) {
          return true;
        }
      }
      return false;
    },
    getPossibleMoves(tower) {
      let possibles = [];
      if (tower === null) return possibles;
      let y = this.nextY(tower.y, tower.playerId);
      let xLeft = tower.x - 1;
      let xRight = tower.x + 1;

      // Vertical
      while (this.getTower(tower.x, y) === null && y >= 1 && y <= 8) {
        possibles.push({ x: tower.x, y: y });
        y = this.nextY(y, tower.playerId);
      }

      // Diagonally to the left
      y = this.nextY(tower.y, tower.playerId);
      while (
        this.getTower(xLeft, y) === null &&
        y >= 1 &&
        y <= 8 &&
        xLeft >= 1
      ) {
        possibles.push({ x: xLeft, y: y });
        y = this.nextY(y, tower.playerId);
        xLeft--;
      }

      // Diagonally to the right
      y = this.nextY(tower.y, tower.playerId);
      while (
        this.getTower(xRight, y) === null &&
        y >= 1 &&
        y <= 8 &&
        xRight <= 8
      ) {
        possibles.push({ x: xRight, y: y });
        y = this.nextY(y, tower.playerId);
        xRight++;
      }

      return possibles;
    },
    nextY(y, playerId) {
      return playerId === 0 ? y + 1 : y - 1;
    },
    tileClicked(x, y) {
      if (this.isPossibleMove(x, y)) {
        this.moveTower(this.selectedTower, x, y);
        this.switchTurn();
        let towerToPlay = this.getTowerByPlayerIdAndColor(
          this.turn,
          this.tileColors[y - 1][x - 1]
        );
        this.setSelectedTower(towerToPlay);
      }
    },
    moveTower(tower, newX, newY) {
      tower.x = newX;
      tower.y = newY;
      this.isFirstTurn = false;
    },
    setSelectedTower(tower) {
      this.selectedTower = tower;
      this.possibleMovesArray = this.getPossibleMoves(tower).slice();
    },
    updateBoard() {
      this.towers = [
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
      ];
    }
  },
  created() {
    // axios.get("defaultBoard/tileColors.json").then(res => {
    //   const data = res.data;
    //   const rows = [];
    //   for (let key in data) {
    //     const row = [];
    //     for (let sec_key in data[key]) {
    //       row.push(data[key][sec_key]);
    //     }
    //     rows.push(row);
    //   }
    //   this.tileColorsAxios = rows.slice();
    //});
    this.updateBoard();
  },
  components: {
    AppTower: Tower
  }
};
</script>

<style scoped>
table {
  margin: auto;
}
td {
  width: 10vh;
  height: 10vh;
}
td.possible {
  box-shadow: 0 0 30px 0 #000 inset;
}
td.possible:hover {
  cursor: pointer;
}
</style>

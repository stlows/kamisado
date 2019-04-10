<template>
  <div>
    <h3>The board</h3>
    <table v-if="tileColors.length > 0">
      <tr v-for="y in 8" :key="'kamiRow_' + y">
        <td
          v-for="x in 8"
          :key="'tile_' + x + '_' + y"
          :style="{backgroundColor: getColor(tileColors[y-1][x-1])}"
        >
          <app-tower v-if="getTower(x,y) !== null" :tower="getTower(x,y)"></app-tower>
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
      towers: []
    };
  },
  methods: {
    getColor(id) {
      return Colors.tiles[id];
    },
    getTower(x, y) {
      for (let i in this.towers) {
        if (this.towers[i].x === x && this.towers[i].y === y) {
          return this.towers[i];
        }
      }
      return null;
    },
    updateBoard() {
      this.towers = [
        { playerId: 0, colorId: 0, x: 1, y: 1, sumo: 0 },
        { playerId: 0, colorId: 1, x: 2, y: 1, sumo: 0 },
        { playerId: 0, colorId: 2, x: 3, y: 1, sumo: 0 },
        { playerId: 0, colorId: 3, x: 4, y: 1, sumo: 0 },
        { playerId: 0, colorId: 4, x: 5, y: 1, sumo: 0 },
        { playerId: 0, colorId: 5, x: 2, y: 5, sumo: 0 },
        { playerId: 0, colorId: 6, x: 7, y: 1, sumo: 0 },
        { playerId: 0, colorId: 7, x: 8, y: 1, sumo: 0 },
        { playerId: 1, colorId: 7, x: 1, y: 8, sumo: 0 },
        { playerId: 1, colorId: 6, x: 2, y: 8, sumo: 0 },
        { playerId: 1, colorId: 5, x: 3, y: 8, sumo: 0 },
        { playerId: 1, colorId: 4, x: 4, y: 8, sumo: 0 },
        { playerId: 1, colorId: 3, x: 4, y: 4, sumo: 0 },
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
</style>

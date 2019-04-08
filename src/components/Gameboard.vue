<template>
  <div>
    <h3>The board</h3>
    <div class="container" v-if="tileColors.length > 0">
      <div class="row no-gutters tile-rows text-center" v-for="i in 8" :key="'kamiRow_' + i">
        <div
          class="col tile"
          v-for="j in 8"
          :key="'tile_' + i + '_' + j"
          :style="{backgroundColor: tileColors[i-1][j-1]}"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import Tile from "./Tile.vue";
import axios from "axios";
import TileColors from "../assets/TileColors.json";

export default {
  data() {
    return {
      tileColors: TileColors
    };
  },
  created() {
    axios.get("defaultBoard/tileColors.json");
  }
};
</script>

<style scoped>
.tile-rows {
  height: 10vh;
  display: block;
}
.tile {
  max-width: 10vh;
}
</style>

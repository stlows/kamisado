<template>
  <div>
    <h3>The board</h3>
    <div class="container">
      <div class="row no-gutters tile-rows text-center" v-for="i in 8" :key="'kamiRow_' + i">
        <div
          class="col tile"
          :style="{backgroundColor: tileColors['r' + i]['c' + j]}"
          v-for="j in 8"
          :key="'tile_' + i + '_' + j"
        ></div>
      </div>
    </div>
  </div>
</template>

<script>
import Tile from "./Tile.vue";
import axios from "axios";

export default {
  data() {
    return {
      tileColors: {}
    };
  },
  components: {
    AppTile: Tile
  },
  created() {
    axios.get("defaultBoard/tileColors.json").then(response => {
      this.tileColors = response.data;
    });
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

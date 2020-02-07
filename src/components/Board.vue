<template>
  <svg v-if="tiles" class="board" :width="8 * tileSize" :height="8 * tileSize">
    <g class="board--background">
      <BoardTile
        v-for="(tile, i) in tiles"
        :key="i"
        :color="tile.color"
        :tileSize="tileSize"
        :x="tile.position_x - 1"
        :y="tile.position_y - 1"
      />
    </g>
    <g class="towers">
      <Tower
        v-for="tower in towers"
        :key="tower.id"
        :tower="tower"
        :towerSize="0.8 * tileSize"
        :tileSize="tileSize"
      />
    </g>
  </svg>
</template>

<script>
import BoardTile from "./BoardTile";
import Tower from "./Tower";
import { mapActions } from "vuex";
export default {
  components: {
    BoardTile,
    Tower
  },
  props: ["towers"],
  data() {
    return {
      tiles: null,
      tileSize: 90
    };
  },
  methods: {
    ...mapActions(["getTiles"])
  },
  created() {
    this.getTiles().then(res => {
      this.tiles = res.data;
    });
  }
};
</script>

<style>
.board {
  display: flex;
  margin: auto;
}
</style>
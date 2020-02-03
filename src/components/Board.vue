<template>
  <svg class="board" :width="8 * tileSize" :height="8 * tileSize">
    <g class="board--background">
      <BoardTile
        v-for="(tile, i) in tiles"
        :key="i"
        :color="tile.color"
        :tileSize="tileSize"
        :x="tile.x"
        :y="tile.y"
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
import InitialTiles from "../assets/InitialTiles.json";
import Tower from "./Tower";
export default {
  components: {
    BoardTile,
    Tower
  },
  props: ["towers"],
  data() {
    return {
      tiles: InitialTiles,
      tileSize: 90
    };
  }
};
</script>

<style>
.board {
  display: flex;
  margin: auto;
}
</style>
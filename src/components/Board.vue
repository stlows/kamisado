<template>
  <svg v-if="tiles" class="board" :width="fullWidth" :height="fullWidth">
    <BoardBorders :borderSize="borderSize" :fullWidth="fullWidth" :tileSize="tileSize" />
    <g :style="'transform: translate(' + borderSize + 'px,' + borderSize + 'px)'">
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
          :borderSize="borderSize"
          :playgroundMode="playgroundMode"
          @towerMoved="towerMoved"
        />
      </g>
    </g>
  </svg>
</template>

<script>
import BoardBorders from "./BoardBorders";
import BoardTile from "./BoardTile";
import Tower from "./Tower";
import { mapActions } from "vuex";
export default {
  components: {
    BoardBorders,
    BoardTile,
    Tower
  },
  props: ["towers", "playgroundMode"],
  data() {
    return {
      tiles: null,
      tileSize: 90,
      borderSize: 30
    };
  },
  computed: {
    fullWidth() {
      return 8 * this.tileSize + 2 * this.borderSize;
    }
  },
  methods: {
    ...mapActions(["getTiles"]),
    towerMoved(tower) {
      this.$emit("towerMoved", tower);
    }
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
  margin: auto;
}
</style>
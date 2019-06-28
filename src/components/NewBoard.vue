<template>
  <div>
    <div id="board">
      <game-tile
        v-for="tile in tiles"
        :key="tile.x + '_' + tile.y"
        :tile="tile"
        @towerClicked="towerClicked"
        @tileClicked="tileClicked"
      ></game-tile>
    </div>
  </div>
</template>

<script>
import Tile from "../components/Tile.vue";

export default {
  props: ["playersTurn", "tiles"],
  components: {
    "game-tile": Tile
  },
  methods: {
    towerClicked(tile) {
      this.$emit("towerClicked", tile);
    },
    tileClicked(tile) {
      this.$emit("tileClicked", tile);
    }
  }
};
</script>

<style lang="scss">
@import "../assets/constants.scss";
#board {
  display: grid;
  grid-template-columns: repeat(8, $tile-size);
  grid-auto-columns: auto;
  width: 8 * $tile-size;
  margin: auto;
  box-shadow: 0 0 20px 0px rgba(black, 0.25);
}
</style>

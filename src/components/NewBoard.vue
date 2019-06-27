<template>
  <div id="board">
    <game-tile v-for="tile in tiles" :tile="tile"></game-tile>
  </div>
</template>

<script>
import Tile from "../components/Tile.vue";

export default {
  data() {
    return {
      tiles: [
        { color: "orange", tower: { color: "orange", playerColor: "white" } },
        { color: "blue", tower: { color: "blue", playerColor: "white" } },
        { color: "indigo", tower: { color: "indigo", playerColor: "white" } },
        { color: "pink", tower: { color: "pink", playerColor: "white" } },
        { color: "yellow", tower: { color: "yellow", playerColor: "white" } },
        { color: "red", tower: { color: "red", playerColor: "white" } },
        { color: "green", tower: { color: "green", playerColor: "white" } },
        { color: "brown", tower: { color: "brown", playerColor: "white" } },
        { color: "red" },
        { color: "orange" },
        { color: "pink" },
        { color: "green" },
        { color: "blue" },
        { color: "yellow" },
        { color: "brown" },
        { color: "indigo" },
        { color: "green" },
        { color: "pink" },
        { color: "orange" },
        { color: "red" },
        { color: "indigo" },
        { color: "brown" },
        { color: "yellow" },
        { color: "blue" },
        { color: "pink" },
        { color: "indigo" },
        { color: "blue" },
        { color: "orange" },
        { color: "brown" },
        { color: "green" },
        { color: "red" },
        { color: "yellow" },
        { color: "yellow" },
        { color: "red" },
        { color: "green" },
        { color: "brown" },
        { color: "orange" },
        { color: "blue" },
        { color: "indigo" },
        { color: "pink" },
        { color: "blue" },
        { color: "yellow" },
        { color: "brown" },
        { color: "indigo" },
        { color: "red" },
        { color: "orange" },
        { color: "pink" },
        { color: "green" },
        { color: "indigo" },
        { color: "brown" },
        { color: "yellow" },
        { color: "blue" },
        { color: "green" },
        { color: "pink" },
        { color: "orange" },
        { color: "red" },
        { color: "brown", tower: { color: "brown", playerColor: "black" } },
        { color: "green", tower: { color: "green", playerColor: "black" } },
        { color: "red", tower: { color: "red", playerColor: "black" } },
        { color: "yellow", tower: { color: "yellow", playerColor: "black" } },
        { color: "pink", tower: { color: "pink", playerColor: "black" } },
        { color: "indigo", tower: { color: "indigo", playerColor: "black" } },
        { color: "blue", tower: { color: "blue", playerColor: "black" } },
        { color: "orange", tower: { color: "orange", playerColor: "black" } }
      ]
    };
  },
  components: {
    "game-tile": Tile
  }
};
</script>

<style lang="scss">
@import "../assets/constants.scss";
#board {
  display: grid;
  grid-template-columns: repeat(8, $tile-size);
  grid-auto-columns: auto;
}
</style>

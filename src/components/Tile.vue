<template>
  <div class="tile" :class="tile.color">
    <game-tower v-if="tile.tower" :tower="tile.tower"></game-tower>
  </div>
</template>

<script>
import Tower from "./Tower";
export default {
  props: ["tile"],
  components: {
    "game-tower": Tower
  }
};
</script>

<style lang="scss">
@import "../assets/_colors.scss";
@import "../assets/_constants.scss";
.tile {
  height: $tile-size;
  display: flex;
  align-items: center;
  justify-items: center;

  &.orange {
    background-color: $orange;
  }
  &.green {
    background-color: $green;
  }
  &.red {
    background-color: $red;
  }
  &.indigo {
    background-color: $indigo;
  }
  &.blue {
    background-color: $blue;
  }
  &.yellow {
    background-color: $yellow;
  }
  &.brown {
    background-color: $brown;
  }
  &.pink {
    background-color: $pink;
  }
}
</style>

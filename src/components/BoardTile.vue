<template>
  <rect
    :width="tileSize"
    :height="tileSize"
    class="tile"
    :class="color"
    :x="tileSize*x"
    :y="tileSize*y"
    :id="'tile_' + (x + 1) + '_' + (y + 1)"
  >
    <title>Tile - {{color}} ({{x + 1}}, {{y + 1}})</title>
  </rect>
</template>

<script>
export default {
  props: ["color", "tileSize", "x", "y"]
};
</script>

<style lang="scss">
@import "../assets/_colors.scss";
@import "../assets/_constants.scss";
.tile {
  &.orange {
    fill: $orange;
  }
  &.green {
    fill: $green;
  }
  &.red {
    fill: $red;
  }
  &.indigo {
    fill: $indigo;
  }
  &.blue {
    fill: $blue;
  }
  &.yellow {
    fill: $yellow;
  }
  &.brown {
    fill: $brown;
  }
  &.pink {
    fill: $pink;
  }
}
</style>
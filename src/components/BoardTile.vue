<template>
  <rect
    :width="tileSize"
    :height="tileSize"
    class="tile"
    :class="color"
    :x="tileSize*x"
    :y="tileSize*y"
  />
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
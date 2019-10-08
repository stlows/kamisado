<template>
  <div
    class="tile"
    :class="[tile.color, { selectable: tile.selectable }]"
    @click="tileClicked"
  >
    <game-tower
      v-if="tile.tower"
      :tower="tile.tower"
      @towerClicked="towerClicked()"
    ></game-tower>
  </div>
</template>

<script>
import Tower from "./Tower";
export default {
  props: ["tile"],
  methods: {
    towerClicked() {
      this.$emit("towerClicked", this.tile);
    },
    tileClicked() {
      this.$emit("tileClicked", this.tile);
    }
  },
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
  &.selectable {
    cursor: pointer;
    box-shadow: 0 0 5px 0 #fff inset, 0 0 0 5px #000 inset;
  }
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

<template>
  <div
    class="tower"
    :class="[
      tower.color,
      tower.playerColor,
      { selectable: tower.selectable, selected: tower.selected }
    ]"
    @click.stop="towerClicked"
  >
    <span v-for="i in tower.sumo" class="sumo" :class="'sumo' + i">★</span>
  </div>
</template>

<script>
export default {
  props: ["tower"],
  methods: {
    towerClicked() {
      this.$emit("towerClicked");
    }
  }
};
</script>

<style lang="scss">
@import "../assets/colors.scss";
@import "../assets/constants.scss";
.tower {
  z-index: 999;
  cursor: default;
  border-radius: 50%;
  line-height: $tower-size;
  width: $tower-size;
  margin: auto;
  position: relative;
  &.selectable {
    cursor: pointer;
  }
  &:after {
    width: 100%;
    height: 100%;
    display: inline-block;
    font-size: $symbol-size;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
  }
  .sumo {
    position: absolute;
    line-height: $sumo-size;
    font-size: $sumo-size;
    &.sumo1 {
      top: 2px;
      left: 50%;
      transform: translateX(-50%);
    }
    &.sumo2 {
      top: 50%;
      transform: translateY(-50%);
      left: 2px;
    }
    &.sumo3 {
      top: 50%;
      transform: translateY(-50%);
      right: 2px;
    }
    &.sumo4 {
      bottom: 2px;
      left: 50%;
      transform: translateX(-50%);
    }
  }

  &.white {
    background-color: $player-white;
    &.selected {
      box-shadow: 0 0 0 3px $player-black, 0 0 0 6px $player-white;
    }
    .sumo {
      color: $player-black;
    }
  }
  &.black {
    background-color: $player-black;
    &.selected {
      box-shadow: 0 0 0 3px $player-white, 0 0 0 6px $player-black;
    }
    .sumo {
      color: $player-white;
    }
  }
  &.orange:after {
    content: "주";
    color: $orange;
  }
  &.blue:after {
    content: "푸";
    color: $blue;
  }
  &.red:after {
    content: "빨";
    color: $red;
  }

  &.yellow:after {
    content: "노";
    color: $yellow;
  }
  &.indigo:after {
    content: "남";
    color: $indigo;
  }
  &.brown:after {
    content: "갈";
    color: $brown;
  }
  &.pink:after {
    content: "담";
    color: $pink;
  }
  &.green:after {
    content: "녹";
    color: $green;
  }
}
</style>

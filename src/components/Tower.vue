<template>
  <div class="tower" :class="[tower.color, tower.playerColor]"></div>
</template>

<script>
export default {
  props: ["tower"]
};
</script>

<style lang="scss">
@import "../assets/colors.scss";
.tower {
  cursor: default;
  border-radius: 50%;
  line-height: 7vh;
  width: 7vh;
  margin: auto;

  &:after {
    width: 7vh;
    height: 7vh;
    display: inline-block;
    font-size: 4vh;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
  }
  &.white {
    background-color: $player-white;
    //box-shadow: 0 0 0 3px #000, 0 0 0 6px #eee;
  }
  &.black {
    background-color: $player-black;
    //box-shadow: 0 0 0 3px #eee, 0 0 0 6px #000;
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

  //[, "gold", "firebrick", "seagreen", "saddlebrown"]
  // ["노", "빨", "녹", "갈"]
}
.tower__symbol {
}
</style>

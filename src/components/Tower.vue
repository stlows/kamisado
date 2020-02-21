<template>
  <g
    class="tower"
    :class="{dragging}"
    :transform="'translate(' + x + ',' + y + ')'"
    @mousedown="mouseDown($event, tower)"
    @mouseup="mouseUp($event)"
  >
    <circle :class="[tower.player_color, tower.tower_color]" :r="towerSize / 2"></circle>
    <text
      text-anchor="middle"
      dominant-baseline="central"
      :class="tower.tower_color"
      :font-size="towerSize * 0.7"
    >{{tower.symbol}}</text>
  </g>
</template>

<script>
export default {
  props: ["tower", "towerSize", "tileSize"],
  data() {
    return {
      x: 0,
      y: 0,
      dragging: false
    };
  },
  methods: {
    mouseDown(ev, tower) {
      this.dragging = true;
      document.addEventListener("mousemove", this.mouseMove);
      document.addEventListener("mouseup", this.mouseUp);
    },
    mouseMove(ev) {
      this.x = ev.offsetX;
      this.y = ev.offsetY;
    },
    mouseUp(ev, towerId) {
      this.dragging = false;
      this.setCoordFromFull();
      this.setFullFromTower();
      this.$emit('towerMoved', this.tower);
      document.removeEventListener("mousemove", this.mouseMove);
      document.removeEventListener("mouseup", this.mouseUp);
    },
    fullToTileCoord(x) {
      return Math.round((x + this.tileSize / 2) / this.tileSize);
    },
    tileToFullCoord(x) {
      return x * this.tileSize - this.tileSize / 2;
    },
    setFullFromTower(){
      this.x = this.tileToFullCoord(this.tower.position_x);
      this.y = this.tileToFullCoord(this.tower.position_y);
    },
    setCoordFromFull(){
      this.tower.position_x = this.fullToTileCoord(this.x);
      this.tower.position_y = this.fullToTileCoord(this.y);
    }
  },
  mounted() {
    this.setFullFromTower();
  }
};
</script>

<style lang="scss">
@import "../assets/colors.scss";
@import "../assets/constants.scss";
.tower {
  cursor: grab;
  transition: transform 0.2s ease;
  &.dragging {
    cursor: grabbing;
    transition: none;
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

  .white {
    fill: $player-white;
  }
  .black {
    fill: $player-black;
  }

  text {
    pointer-events: none;
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
}
</style>

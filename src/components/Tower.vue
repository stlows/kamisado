<template>
  <g style>
    <g v-for="(line, index) in playgroundHistory" :key="index">
      <line class="arrow" :x1="line.x1" :y1="line.y1" :x2="line.x2" :y2="line.y2">
        <title>Playground line</title>
      </line>
      <!-- Problème avec la rotation -->
      <!-- <text
        fill="white"
        text-anchor="middle"
        dominant-baseline="central"
        :x="(line.x2 + line.x1) / 2"
        :y="(line.y2 + line.y1) / 2"
        class="line--index"
        :class="{rotate}"
      >{{index}}</text>-->
    </g>

    <line v-if="dragging" class="arrow" :x1="arrowStartX" :y1="arrowStartY" :x2="x" :y2="y" />

    <g
      class="tower"
      :class="[tower.player_color, tower.tower_color, {dragging}]"
      @mousedown="mouseDown($event)"
      @mouseup="mouseUp($event)"
      :style="'transform: translate(' + x + 'px,' + y + 'px)' "
    >
      <title>Tower — {{tower.player_color}}'s {{tower.tower_color}} — ({{tower.position_x}}, {{tower.position_y}}) — Sumo: {{tower.sumo}}</title>

      <circle :r="towerSize / 2" :stroke="tower.player_color === 'white' ? 'black' : 'white'"></circle>
      <g>
        <circle
          :r="towerSize / 8"
          :stroke="tower.player_color === 'white' ? 'black' : 'white'"
          :style="'transform: translate(' + (towerSize / 3) + 'px, ' + (towerSize / 3) + 'px)'"
          v-if="tower.sumo > 0"
        ></circle>
        <circle
          :r="towerSize / 8"
          :stroke="tower.player_color === 'white' ? 'black' : 'white'"
          :style="'transform: translate(-' + (towerSize / 3) + 'px, ' + (towerSize / 3) + 'px)'"
          v-if="tower.sumo > 1"
        ></circle>
        <circle
          :r="towerSize / 8"
          :stroke="tower.player_color === 'white' ? 'black' : 'white'"
          :style="'transform: translate(' + (towerSize / 3) + 'px, -' + (towerSize / 3) + 'px)'"
          v-if="tower.sumo > 2"
        ></circle>
        <circle
          :r="towerSize / 8"
          :stroke="tower.player_color === 'white' ? 'black' : 'white'"
          :style="'transform: translate(-' + (towerSize / 3) + 'px, -' + (towerSize / 3) + 'px)'"
          v-if="tower.sumo > 3"
        ></circle>
      </g>

      <text
        text-anchor="middle"
        dominant-baseline="central"
        :font-size="towerSize * 0.6"
        class="tower--symbol"
        :class="{rotate}"
      >{{tower.symbol}}</text>
    </g>
  </g>
</template>

<script>
export default {
  components: {},
  props: [
    "tower",
    "towerSize",
    "tileSize",
    "borderSize",
    "playgroundMode",
    "rotate"
  ],
  data() {
    return {
      x: 0,
      y: 0,
      dragging: false,
      playgroundHistory: [],
      arrowStartX: 0,
      arrowStartY: 0
    };
  },
  methods: {
    mouseDown(ev) {
      this.dragging = true;
      this.arrowStartX = this.x;
      this.arrowStartY = this.y;
      document.addEventListener("mousemove", this.mouseMove);
      document.addEventListener("mouseup", this.mouseUp);
    },
    mouseMove(ev) {
      this.x = Math.max(0, ev.offsetX - this.borderSize);
      this.y = Math.max(0, ev.offsetY - this.borderSize);
    },
    mouseUp(ev) {
      if (!this.dragging) {
        return;
      }
      this.dragging = false;
      this.setCoordFromFull();
      this.setFullFromTower();
      if (!this.playgroundMode) {
        this.$emit("towerMoved", this.tower);
      } else {
        this.playgroundHistory.push({
          x1: this.arrowStartX,
          x2: this.tileToFullCoord(this.tower.position_x),
          y1: this.arrowStartY,
          y2: this.tileToFullCoord(this.tower.position_y)
        });
      }
      document.removeEventListener("mousemove", this.mouseMove);
      document.removeEventListener("mouseup", this.mouseUp);
    },
    fullToTileCoord(x) {
      return Math.min(
        8,
        Math.max(1, Math.round((x + this.tileSize / 2) / this.tileSize))
      );
    },
    tileToFullCoord(x) {
      return x * this.tileSize - this.tileSize / 2;
    },
    setFullFromTower() {
      this.x = this.tileToFullCoord(this.tower.position_x);
      this.y = this.tileToFullCoord(this.tower.position_y);
    },
    setCoordFromFull() {
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
.arrow {
  stroke: rgba(0, 0, 0, 0.4);
  stroke-dasharray: 60 50;
  stroke-width: 20;
  stroke-linecap: round;
}
.tower {
  cursor: grab;
  &:not(.dragging) {
    transition: all 0.2s ease;
  }

  &.dragging {
    cursor: grabbing;
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
    fill: $player-white;
    & circle.sumo1 {
      fill: $player-black;
    }
    & circle.sumo2 {
      fill: $player-white;
    }
    & circle.sumo3 {
      fill: $player-black;
    }
  }
  &.black {
    fill: $player-black;
    & circle.sumo1 {
      fill: $player-white;
    }
    & circle.sumo2 {
      fill: $player-black;
    }
    & circle.sumo3 {
      fill: $player-white;
    }
  }
  text.tower--symbol {
    &.rotate {
      transform: rotate(180deg);
    }
  }
  &.orange text.tower--symbol {
    fill: $orange;
  }
  &.green text.tower--symbol {
    fill: $green;
  }
  &.red text.tower--symbol {
    fill: $red;
  }
  &.indigo text.tower--symbol {
    fill: $indigo;
  }
  &.blue text.tower--symbol {
    fill: $blue;
  }
  &.yellow text.tower--symbol {
    fill: $yellow;
  }
  &.brown text.tower--symbol {
    fill: $brown;
  }
  &.pink text.tower--symbol {
    fill: $pink;
  }
}
</style>

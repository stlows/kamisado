<template>
  <div>
    <div
      class="tower"
      :class="{ towerAvailable: tower.playerId === turn, 'tower--shadow': selected === tower }"
      :style="{ backgroundColor:getPlayerColor(tower.playerId) }"
      @click="towerClicked"
    >
      <span
        class="tower__text"
        :class="{'tower__text--shadow': selected === tower}"
        :style="{color:getTowerColor(tower.colorId) }"
      >{{ getSymbol(tower.colorId)}}</span>
    </div>
  </div>
</template>

<script>
import Colors from "../assets/Colors.json";
import Symbols from "../assets/Symbols.json";

export default {
  props: ["tower", "turn", "selected"],
  data() {
    return {
      isSelected: true
    };
  },
  methods: {
    getPlayerColor(id) {
      return Colors.players[id];
    },
    getTowerColor(id) {
      return Colors.towers[id];
    },
    getSymbol(id) {
      return Symbols[id];
    },
    towerClicked() {
      if (this.selected === this.tower) {
        this.$emit("towerSelected", null);
        return;
      }
      if (this.turn === this.tower.playerId) {
        this.$emit("towerSelected", this.tower);
      }
    }
  }
};
</script>

<style>
.tower {
  cursor: default;
  border-radius: 50%;
  line-height: 7vh;
  width: 7vh;
  margin: auto;
}
.tower__text {
  width: 7vh;
  height: 7vh;
  display: inline-block;
  font-size: 4vh;
  font-weight: bold;
  text-align: center;
  vertical-align: middle;
}
.tower--shadow {
  box-shadow: 0 0 2vh 0px #222;
}
.tower__text--shadow {
  text-shadow: 0 0 1vh #222;
}
.towerAvailable:hover {
  cursor: pointer;
}
</style>

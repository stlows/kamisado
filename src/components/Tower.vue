<template>
  <div>
    <svg width="10vh" height="10vh">
      <circle
        cx="50%"
        cy="50%"
        r="35%"
        class="tower"
        :fill="getPlayerColor(tower.playerId)"
        :class="{towerAvailable: tower.playerId === turn}"
        @click="towerClicked"
      ></circle>
      <text
        class="tower"
        :class="{towerAvailable: tower.playerId === turn}"
        text-anchor="middle"
        alignment-baseline="central"
        x="50%"
        y="50%"
        font-size="4vh"
        font-weight="bold"
        :fill="getTowerColor(tower.colorId)"
        @click="towerClicked"
      >{{ getSymbol(tower.colorId)}}</text>
    </svg>
  </div>
</template>

<script>
import Colors from "../assets/Colors.json";
import Symbols from "../assets/Symbols.json";

export default {
  props: ["tower", "turn"],
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
      if (this.turn === this.tower.playerId) {
        console.log("clicked");
      }
    }
  }
};
</script>

<style>
.tower {
  cursor: default;
}
.towerAvailable:hover {
  cursor: pointer;
}
</style>

<template>
  <div class="tower">
    <svg width="10vh" height="10vh">
      <circle
        cx="50%"
        cy="50%"
        r="30%"
        :stroke="getPlayerColor(tower.playerId)"
        stroke-width="10%"
        :fill="getTowerColor(tower.colorId)"
      ></circle>
      <text
        text-anchor="middle"
        alignment-baseline="central"
        x="50%"
        y="50%"
        font-size="3vh"
        font-weight="bold"
        :fill="getPlayerColor(tower.playerId)"
      >{{ getSymbol(tower.colorId)}}</text>
    </svg>
  </div>
</template>

<script>
import Colors from "../assets/Colors.json";
import Symbols from "../assets/Symbols.json";

export default {
  props: ["tower"],
  methods: {
    getPlayerColor(id) {
      return Colors.players[id];
    },
    getTowerColor(id) {
      return Colors.towers[id];
    },
    getSymbol(id) {
      return Symbols[id];
    }
  }
};
</script>

<style>
</style>

<template>
  <div class="tower">
    <svg width="10vh" height="10vh">
      <circle
        cx="50%"
        cy="50%"
        r="40%"
        :stroke="getPlayerColor(tower.playerId)"
        stroke-width="10%"
        :fill="getTowerColor(tower.colorId)"
      ></circle>
    </svg>
  </div>
</template>

<script>
import Colors from "../assets/Colors.json";

export default {
  props: ["tower"],
  methods: {
    getPlayerColor(colorId) {
      return Colors.players[colorId];
    },
    getTowerColor(colorId) {
      return Colors.towers[colorId];
    }
  }
};
</script>

<style>
</style>

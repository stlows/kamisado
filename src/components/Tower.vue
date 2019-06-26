<template>
  <div :class="getTowerClass(x,y)" :style="getTowerStyle(x,y)" @click="clicked">
    <span
      class="tower__symbol"
      :style="{color:getTowerColor( getTower(x,y).colorId) }"
    >{{ getSymbol( getTower(x,y).colorId)}}</span>
  </div>
</template>

<script>
export default {
  props: ["tower"],
  methods: {
    clicked() {},
    getTowerClass() {
      let classes = ["tower"];
      if (tower.playerId === this.turn && this.moves.length === 0) {
        classes.push("possible");
      }
      if (this.selectedTower !== null && this.selectedTower === tower) {
        classes.push("tower--selectedPlayer" + this.turn);
      }
      if (tower.isWon) {
        classes.push("tower--winner");
      }
      return classes;
    },
    getTowerStyle(x, y) {
      return {
        backgroundColor: this.getPlayerColor(this.getTower(x, y).playerId)
      };
    }
  }
};
</script>

<style>
</style>

<template>
  <div>
    <h2>This is the game</h2>
    <app-gameboard></app-gameboard>
  </div>
</template>

<script>
import Gameboard from "../components/Gameboard.vue";

export default {
  data() {
    return {};
  },
  components: {
    AppGameboard: Gameboard
  }
};
</script>


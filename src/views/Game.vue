<template>
  <div>
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


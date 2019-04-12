<template>
  <div>
    <app-gameboard @notify="notify"></app-gameboard>
  </div>
</template>

<script>
import Gameboard from "../components/Gameboard.vue";

export default {
  data() {
    return {};
  },
  methods: {
    notify(e) {
      this.$emit("notify", e);
    }
  },
  components: {
    AppGameboard: Gameboard
  }
};
</script>


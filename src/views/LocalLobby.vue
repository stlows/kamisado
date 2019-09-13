<template>
  <div>
    <h1 class="header">Local lobby</h1>
    <button
      class="btn btn-large btn-primary"
      @click="newGameVsAi"
      disabled
      title="Not yet implemented..."
    >New game vs. AI</button>
    <button class="btn btn-large btn-primary" @click="newGameVsHuman">New game vs. Human</button>
  </div>
</template>

<script>
export default {
  methods: {
    newGameVsAi() {},
    newGameVsHuman() {
      this.$router.push({name: "local/newGame"});
    }
  }
};
</script>

<style scoped>
button {
  display: block;
  margin: auto;
  margin-bottom: 15px;
}
</style>

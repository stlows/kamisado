<template>
  <div class="container">
    <h1>Local Lobby</h1>
    <button class="btn btn-large btn-primary" @click="newGameVsHuman">VS. HUMAN</button>
    <button
      class="btn btn-large btn-primary"
      @click="newGameVsAi"
      disabled
      title="Not yet implemented..."
    >VS. AI</button>
  </div>
</template>

<script>
export default {
  methods: {
    newGameVsAi() {},
    newGameVsHuman() {
      this.$router.push("/local/settings");
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

<template>
  <div>
    <h1 class="header">Local games</h1>
    <button
      class="btn btn-large btn-primary"
      @click="newGameVsAi"
      disabled
      title="Not yet implemented..."
    >Vs. AI</button>
    <button class="btn btn-large btn-primary" @click="newGameVsHuman">Vs. Human</button>
  </div>
</template>

<script>
export default {
  methods: {
    newGameVsAi() {},
    newGameVsHuman() {
      let vusers = [
        { username: "cprovost", name: "Charles", score: 0, color: "white" },
        { username: "vbeaulieu", name: "Vincent", score: 0, color: "black" }
      ];
      let settings = {
        pointsToWin: 15
      };
      this.$router.push({
        name: "local/game",
        params: { users: vusers, settings: settings }
      });
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

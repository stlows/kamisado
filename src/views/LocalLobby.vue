<template>
  <div>
    <h1 class="header">Local lobby</h1>
    <ul>
      <li v-for="localGame in $store.state.localGames" :key="localGame.id">
        <b-link :to="{ name: 'local/game', params: { id: localGame.id } }">{{ localGame.id }}</b-link>
      </li>
    </ul>
    <button class="btn btn-large btn-primary" @click="newGameVsHuman">New game</button>
  </div>
</template>

<script>
export default {
  methods: {
    newGameVsAi() {},
    newGameVsHuman() {
      this.$router.push({name: "newGame"});
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

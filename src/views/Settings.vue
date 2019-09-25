<template>
  <div>
    <div class="container">
      <h1>Settings</h1>
      <div class="form-group">
        <label for="white-name">White's name</label>
        <input type="text" v-model="users[0].name">
      </div>
      <div class="form-group">
        <label for="black-name">Black's name</label>
        <input type="text" v-model="users[1].name">
      </div>
      <div class="form-group">
        <label for="pointsToWin">Points to win</label>
        <input type="number" v-model="settings.pointsToWin">
      </div>
      <button class="btn btn-large btn-primary" @click="newGameVsHuman">All set !</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [
        { username: "username", name: "Charles", score: 0, color: "white" },
        { username: "username", name: "Vincent", score: 0, color: "black" }
      ],
      settings: {
        pointsToWin: 7
      }
    };
  },
  methods: {
    newGameVsHuman() {
      console.log(this.users);
      this.$router.push({
        name: "local/game",
        params: { users: this.users, settings: this.settings }
      });
    }
  }
};
</script>

<style lang="scss">
.container {
  box-shadow: 0 0 15px rgba(black, 0.25);
  padding: 2em 1em;
  margin-top: 30px;
  .form-group {
    label {
      margin-bottom: 0;
      line-height: 44px;
      margin-right: 15px;
    }
    input {
      padding: 0.5em;
      max-width: 200px;
    }
  }
}
</style>

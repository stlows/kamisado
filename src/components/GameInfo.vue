<template>
  <div id="gameInfo">
    <h3>Game ID: {{ $route.params.id }}</h3>
    <table id="scores">
      <thead>
        <tr>
          <th>{{ users[0].username }} ({{users[0].color}})</th>
          <th>{{ users[1].username }} ({{users[1].color}})</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>{{ users[0].score }}</th>
          <th>{{ users[1].score }}</th>
        </tr>
      </tbody>
    </table>
    <p>{{ getTurnsUsername }}'s turn</p>
  </div>
</template>

<script>
export default {
  props: ["users", "playersTurn"],
  computed: {
    getTurnsUsername() {
      return this.users.find(u => u.color === this.playersTurn).username;
    }
  }
};
</script>

<style scoped lang="scss">
h3 {
  margin: 1em;
}
#scores {
  display: inline-block;
  box-shadow: 0 0 10px rgba(black, 0.2);
  margin-bottom: 1em;
  th,
  td {
    padding: 10px;
  }
  th:first-child {
    border-right: 1px solid #eee;
  }

  thead {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
  }
}
</style>




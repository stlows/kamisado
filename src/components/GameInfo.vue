<template>
  <div id="gameInfo">
    <h3>Game ID: {{ game.id }}</h3>
    <table id="scores">
      <thead>
        <tr>
          <th>{{ game.users[0].username }}</th>
          <th>{{ game.users[1].username }}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>{{ game.users[0].score }}</th>
          <th>{{ game.users[1].score }}</th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["game"]
};
</script>

<style scoped lang="scss">
h3 {
  margin: 1em;
}
#scores {
  display: inline-block;
  box-shadow: 0 0 10px rgba(black, 0.2);
  th,
  td {
    padding: 1em;
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




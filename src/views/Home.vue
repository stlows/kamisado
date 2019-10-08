<template>
  <div>
    <h1 class="header">가미 사도 &mdash; Kamisado</h1>
    <ul class="list-group container">
      <li class="list-group-item">
        <b-link to="/local/lobby">Local lobby</b-link>
      </li>
      <li class="list-group-item">
        <b-link to="/online/lobby" :disabled="true" title="Not yet implemented...">Online lobby</b-link>
      </li>
      <li class="list-group-item">
        <b-link to="/newGame">New game</b-link>
      </li>
      <li class="list-group-item">
        <b-link to="/tutorial" :disabled="true" title="Not yet implemented...">Tutorial</b-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  methods: {
    localLobby() {}
  }
};
</script>

<style>
a.disabled {
  opacity: 0.5;
  cursor: default;
  text-decoration: none;
}
</style>

<template>
  <div>
    <h1 class="header">Kamisado</h1>
    <ul class="list-group container">
      <li class="list-group-item">
        <router-link to="/local/lobby">Local Lobby</router-link>
      </li>
      <li class="list-group-item">
        <router-link to="/online/lobby">Online games</router-link>
      </li>
      <li class="list-group-item">
        <router-link to="/tutorial" disabled>Tutorial</router-link>
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
</style>

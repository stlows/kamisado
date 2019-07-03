<template>
  <div>
    <h1 class="header">Kamisado</h1>
    <ul class="list-group container">
      <li class="list-group-item">
        <a @click.prevent="localLobby" href="#">Local games</a>
      </li>
      <li class="list-group-item">
        <a @click.prevent="localLobby" href="#">Online games</a>
      </li>
      <li class="list-group-item">
        <a @click.prevent="localLobby" href="#">Tutorial</a>
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

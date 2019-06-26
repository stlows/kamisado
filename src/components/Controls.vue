<template>
  <div id="game-controls">
    <p>White's score: {{ scores[0] }}</p>
    <p>Blacks's score: {{ scores[0] }}</p>
    <h3>Game: {{ gameId }}</h3>
    <h5>{{ turn === 0 ? "White" : "Black" }}'s turn</h5>
    <input type="text" v-model="userId">
    <span>{{userId}}</span>
    <button
      class="btn btn-primary mb-3"
      @click="confirmMove"
      :disabled="!isMyTurn || moveToConfirm === null"
    >{{ saveButtonText }}</button>
    <br>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>

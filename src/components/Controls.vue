<template>
  <div id="game-controls">
    <input type="text" v-model="userId" />
    <span>{{ userId }}</span>
    <button
      class="btn btn-primary mb-3"
      @click="confirmMove"
      :disabled="!isMyTurn || moveToConfirm === null"
    >
      {{ saveButtonText }}
    </button>
    <br />
  </div>
</template>

<script>
export default {
  props: ["moveToConfirm", "scores"],
  data() {
    return {};
  }
};
</script>

<style></style>

<template>
  <div class="tileContent"></div>
</template>

<script>
export default {
  data() {
    return {
      styleObject: {
        backgroundColor: this.tileColor
      }
    };
  }
};
</script>

<style>
.tile {
  display: inline-block;
  height: 100%;
  width: 100%;
}
</style>

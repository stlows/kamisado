<template>
  <g class="board--borders">
    <rect :width="fullWidth" :height="borderSize" class="border" x="0" y="0" />
    <rect :width="borderSize" :height="fullWidth" class="border" x="0" y="0" />
    <rect :width="fullWidth" :height="borderSize" class="border" x="0" :y="fullWidth - borderSize" />
    <rect :width="borderSize" :height="fullWidth" class="border" :x="fullWidth - borderSize" y="0" />
    <template v-for="i in 2">
      <text
        v-for="(item, index) in rows"
        text-anchor="middle"
        dominant-baseline="central"
        :font-size="borderSize * 0.7"
        :x="tileSize * (index + 1/2) + borderSize"
        :y="borderSize / 2 + (fullWidth- borderSize)*(i-1) "
        :key="i + '_' +item"
        class="helper"
      >{{item}}</text>
    </template>
    <template v-for="i in 2">
      <text
        v-for="(item, index) in columns"
        text-anchor="middle"
        dominant-baseline="central"
        :font-size="borderSize * 0.7"
        :x="borderSize / 2 + (fullWidth- borderSize)*(i-1)"
        :y="tileSize * (index + 1/2) + borderSize"
        :key="i + '_' +item"
        class="helper"
      >{{item}}</text>
    </template>
  </g>
</template>

<script>
export default {
  props: ["borderSize", "fullWidth", "tileSize"],
  data() {
    return {
      rows: ["A", "B", "C", "D", "E", "F", "G", "H"],
      columns: ["1", "2", "3", "4", "5", "6", "7", "8"]
    };
  }
};
</script>

<style lang="scss">
.board--borders {
  .border {
    fill: rgb(26, 23, 39);
  }
  .helper {
    pointer-events: none;
    user-select: none;
    fill: rgb(218, 223, 250);
  }
}
</style>
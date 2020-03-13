<template>
  <g class="board--borders">
    <rect :width="fullWidth" :height="borderSize" class="border top-border-bg" x="0" y="0">
      <title>Border</title>
    </rect>
    <rect :width="borderSize" :height="fullWidth" class="border left-border-bg" x="0" y="0">
      <title>Border</title>
    </rect>
    <rect
      :width="fullWidth"
      :height="borderSize"
      class="border bottom-border-bg"
      x="0"
      :y="fullWidth - borderSize"
    >
      <title>Border</title>
    </rect>
    <rect
      :width="borderSize"
      :height="fullWidth"
      class="border right-border-bg"
      :x="fullWidth - borderSize"
      y="0"
    >
      <title>Border</title>
    </rect>
    <template v-for="i in 2">
      <text
        v-for="(item, index) in rows"
        text-anchor="middle"
        dominant-baseline="central"
        :font-size="borderSize * 0.7"
        :x="rotate ? tileSize * (index + 1/2) + borderSize * 1.5 : tileSize * (index + 1/2) + borderSize"
        :y="rotate ? (fullWidth- borderSize)*(i-1) : borderSize / 2 + (fullWidth- borderSize)*(i-1) "
        :key="'row_' + i + '_' + item"
        :rotate="rotate ? '180' : '0'"
        class="helper"
      >{{item}}</text>
    </template>
    <template v-for="i in 2">
      <text
        v-for="(item, index) in columns"
        text-anchor="middle"
        dominant-baseline="central"
        :font-size="borderSize * 0.7"
        :x="rotate ? borderSize + (fullWidth- borderSize)*(i-1) : borderSize / 2 + (fullWidth- borderSize)*(i-1)"
        :y="rotate ? tileSize * (index + 0.5) + borderSize / 2 : tileSize * (index + 1/2) + borderSize"
        :key="'col_' + i + '_' +item"
        class="helper"
        :rotate="rotate ? '180' : '0'"
      >{{item}}</text>
    </template>
  </g>
</template>

<script>
export default {
  props: ["borderSize", "fullWidth", "tileSize", "rotate"],
  data() {
    return {
      rows: ["1", "2", "3", "4", "5", "6", "7", "8"],
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
    fill: rgb(218, 223, 250);
    &.rotate {
      transform: rotate(180deg);
      transform-origin: center center;
    }
  }
}
</style>
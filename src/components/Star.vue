<template>
  <g>
    <!--
  <polygon 
  :points="`#{100*size},#{10*size} #{40*size},#{198*size} #{190*size},#{78*size} #{10*size},#{78*size} #{160*size},#{198*size}`"
  :style="$`fill:#{color};fill-rule:nonzero;`"/>
    -->
    <polygon :points="points" :style="'fill:' + color" style="fill-rule:nonzero;" />
  </g>
</template> 

<script>
export default {
  props: ["size", "color"],
  computed: {
    points() {
      return [
        [100, 10],
        [40, 198],
        [190, 78],
        [10, 78],
        [160, 198]
      ]
        .map(point => [point[0] * this.size, point[1] * this.size])
        .map(point => point[0] + "," + point[1])
        .join(" ");
    }
  }
};
</script>

<style>
</style>
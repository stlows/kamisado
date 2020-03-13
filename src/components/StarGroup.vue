<template>
  <g :style="'transform: rotate(' + rotate-group + 'deg)' ">
    <Star :color="color" :size="0.06" style="transform:translate(-6px, -36px)"></Star>
    <Star :color="color" :size="0.06" style="transform:translate(-6px, 22px)"></Star>
    <Star :color="color" :size="0.06" style="transform:translate(-35px, -5px)"></Star>
    <Star :color="color" :size="0.06" style="transform:translate(22px, -5px)"></Star>
  </g>
</template>

<script>
import Star from "./Star";
export default {
  props: ["color", "rotate-group"],
  components: { Star }
};
</script>

<style>
</style>
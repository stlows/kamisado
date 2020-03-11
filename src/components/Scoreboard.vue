<template>
<div>
  <b-table-simple class="w-25">
    <b-thead>
      <b-tr>
        <b-th :class="{'bg-light': game.turn_color === 'white'}">{{game.player_1_name}} (White)</b-th>
        <b-th :class="{'bg-light': game.turn_color === 'black'}">{{game.player_2_name}} (Black)</b-th>
      </b-tr>
    </b-thead>
    <b-tbody>
      <b-tr>
        <b-td :class="{'bg-light': game.turn_color === 'white'}">{{game.player_1_score}} (White)</b-td>
        <b-td :class="{'bg-light': game.turn_color === 'black'}">{{game.player_2_score}} (Black)</b-td>
      </b-tr>
    </b-tbody>
  </b-table-simple>
</div>
</template>

<script>
export default {
  props: ["game"]
}
</script>

<style>

</style>
<template>
  <b-card>
    <b-card-title>Active game: {{game.game_id}}</b-card-title>
    <b-card-body>
      <b-list-group>
        <b-list-group-item class="d-flex justify-content-between align-items-center">
          <span
            :class="{'font-weight-bold': game.turn_color === 'white'}"
          >{{game.player_1_name}} [white] ({{game.player_1_score}})</span>
          <span class="vs">vs.</span>
          <span
            :class="{'font-weight-bold': game.turn_color === 'black'}"
          >{{game.player_2_name}} [black] ({{game.player_2_score}})</span>
        </b-list-group-item>
        <b-list-group-item class="d-flex justify-content-between align-items-center">
          <span>Points to win</span>
          <span>{{game.points_to_win}}</span>
        </b-list-group-item>
        <b-list-group-item class="d-flex justify-content-between align-items-center">
          <span>Turn</span>
          <span>{{game.turn_color}} ({{ game.turn_color === 'white' ? game.player_1_name : game.player_2_name }})</span>
        </b-list-group-item>
        <b-list-group-item class="d-flex justify-content-between align-items-center">
          <span>Tower to move</span>
          <span>{{towerToMove}}</span>
        </b-list-group-item>
      </b-list-group>
    </b-card-body>
  </b-card>
</template>

<script>
export default {
  components: {},
  props: ["game"],
  computed: {
    towerToMove() {
      if (this.game.tower_id_to_move) {
        return this.game.turn_tower_color;
      } else {
        return "any";
      }
    }
  }
};
</script>

<style>
.vs {
  margin: 0 10px;
  text-transform: uppercase;
  color: rgb(31, 32, 90);
}
</style>
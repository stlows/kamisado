<template>
  <b-card>
    <b-card-title v-if="game">Active game: {{game.game_id}}</b-card-title>
    <b-card-title v-else>No game selected</b-card-title>
    <b-card-body v-if="game">
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
          <span class="tower-color" :class="[towerToMove]">{{towerToMove}}</span>
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

<style lang="scss">
@import "../assets/colors.scss";

.vs {
  margin: 0 10px;
  text-transform: uppercase;
  color: rgb(31, 32, 90);
}
.tower-color {
  &.orange {
    color: $orange;
  }
  &.green {
    color: $green;
  }
  &.red {
    color: $red;
  }
  &.indigo {
    color: $indigo;
  }
  &.blue {
    color: $blue;
  }
  &.yellow {
    color: $yellow;
  }
  &.brown {
    color: $brown;
  }
  &.pink {
    color: $pink;
  }
}
</style>
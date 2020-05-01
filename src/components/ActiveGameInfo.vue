<template>
  <v-card class="pa-6">
    <h2 v-if="game">Active game: {{game.game_id}}</h2>
    <h2 v-else>No game selected</h2>
    <v-card-text v-if="game">
      <v-list-item class="d-flex justify-content-between align-items-center">
        <span
          :class="{'font-weight-bold': game.turn_color === 'white'}"
        >{{game.player_1_name}} [white] ({{game.player_1_score}})</span>
        <span class="vs">vs.</span>
        <span
          :class="{'font-weight-bold': game.turn_color === 'black'}"
        >{{game.player_2_name}} [black] ({{game.player_2_score}})</span>
      </v-list-item>
      <v-list-item class="d-flex justify-content-between align-items-center">
        <span>Points to win</span>
        <span>{{game.points_to_win}}</span>
      </v-list-item>
      <v-list-item class="d-flex justify-content-between align-items-center">
        <span>Turn</span>
        <span>{{game.turn_color}} ({{ game.turn_color === 'white' ? game.player_1_name : game.player_2_name }})</span>
      </v-list-item>
      <v-list-item class="d-flex justify-content-between align-items-center">
        <span>Tower to move</span>
        <span class="tower-color" :class="[towerToMove]">{{towerToMove}}</span>
      </v-list-item>
    </v-card-text>
  </v-card>
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
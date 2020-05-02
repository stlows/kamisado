<template>
  <v-card class="pa-6" min-width="500">
    <h2 class="mb-3" v-if="game">Active game: {{game.game_id}}</h2>
    <h2 v-else>No game selected</h2>
    <template v-if="game">
      <v-list-item>
        <span
          :class="{'font-weight-bold': game.turn_color === 'white'}"
        >{{game.player_1_name}} [white] ({{game.player_1_score}})</span>
        <v-spacer></v-spacer>
        <span class="vs">vs.</span>
        <v-spacer></v-spacer>
        <span
          :class="{'font-weight-bold': game.turn_color === 'black'}"
        >{{game.player_2_name}} [black] ({{game.player_2_score}})</span>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-item>
        <span>Points to win</span>
        <v-spacer></v-spacer>
        <span>{{game.points_to_win}}</span>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-item>
        <span>Turn</span>
        <v-spacer></v-spacer>
        <span>{{game.turn_color}} ({{ game.turn_color === 'white' ? game.player_1_name : game.player_2_name }})</span>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-item>
        <span>Tower to move</span>
        <v-spacer></v-spacer>
        <span>{{towerToMove}}</span>
      </v-list-item>
    </template>
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
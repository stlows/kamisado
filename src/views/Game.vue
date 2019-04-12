<template>
  <div>
    <p>White's score: {{ scores[0] }}</p>
    <p>Blacks's score: {{ scores[0] }}</p>
    <app-gameboard @notify="notify" :users="users" @winRound="winRound"></app-gameboard>
  </div>
</template>

<script>
import Gameboard from "../components/Gameboard.vue";

export default {
  data() {
    return {
      users: [
        { id: "User4563", username: "Charles" },
        { id: "User4564", username: "Vincent" }
      ],
      scores: [0, 0],
      pointsToWin: 5
    };
  },
  methods: {
    notify(e) {
      this.$emit("notify", e);
    },
    winRound(e) {
      this.scores[e.playerId] += e.points;
      this.$emit("notify", {
        message: this.users[e.playerId].username + " wins the round!",
        variant: "success"
      });
    }
  },
  components: {
    AppGameboard: Gameboard
  }
};
</script>


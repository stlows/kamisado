<template>
  <div>
    <game-controls></game-controls>

    <game-board
      @notify="notify"
      @save-round="saveRound"
      :users="users"
      @winRound="winRound"
      :roundId="activeRound"
      :gameId="gameId"
    ></game-board>
  </div>
</template>

<script>
import Gameboard from "../components/Gameboard.vue";
import GameControls from "../components/GameControls.vue";
import axios from "axios";
export default {
  data() {
    return {
      gameId: this.$route.params.id,
      users: [],
      scores: [],
      pointsToWin: 0,
      rounds: []
    };
  },
  computed: {
    activeRound() {
      return this.rounds.length - 1;
    }
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
    },
    loadGame() {
      axios.get("games/" + this.gameId + ".json").then(res => {
        const data = res.data;

        this.pointsToWin = data.pointsToWin;
        this.scores = data.scores;

        const users = [];
        for (let key in data.users) {
          users.push(data.users[key]);
        }
        this.users = users;

        this.rounds = data.rounds;
        // console.log(rounds);
        // for (let key in rounds) {
        //   console.log(key);
        //   console.log(rounds[key]);
        //   const round = {};
        //   const towers = [];
        //   for (let key in rounds[key].towers) {
        //     towers.push(rounds[key].towers[key]);
        //   }
        //   round.towers = towers;
        //   round.turn = rounds[key].turn;
        //   round.selectedTowerId = rounds[key].selectedTowerId;
        //   round.moves =
        //     typeof rounds[key].moves === "undefined"
        //       ? []
        //       : data.rounds[key].moves;
        //   rounds.push(round);
        // }

        // this.rounds = rounds;

        this.$emit("notify", {
          message: "✓ Game loaded",
          variant: "success"
        });
      });
    },
    saveGame() {
      axios
        .put("games/" + this.gameId + ".json", {
          rounds: this.rounds,
          pointsToWin: this.pointsToWin,
          scores: this.scores,
          users: this.users
        })
        .then(res => {
          this.$emit("notify", {
            message: "✓ Game saved",
            variant: "success"
          });
        });
    },
    saveRound(round) {
      axios
        .put("games/" + this.gameId + "/rounds/" + this.activeRound + ".json", {
          towers: round.towers,
          turn: round.turn,
          moves: round.moves,
          selectedTowerId: round.selectedTowerId
        })
        .then(res => {
          this.$emit("notify", {
            message: "✓ Round saved",
            variant: "success"
          });
        });
    }
  },
  created() {
    this.loadGame();
  },
  components: {
    "game-board": Gameboard,
    "game-controls": GameControls
  }
};
</script>


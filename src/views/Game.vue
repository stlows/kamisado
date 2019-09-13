<template>
  <div>
    <game-manager></game-manager>
  </div>
</template>

<script>
import GameInfo from "../components/GameInfo.vue";
import GameManager from "../components/GameManager.vue";
import Tile from "../components/Tile.vue";
import Controls from "../components/Controls.vue";
import axios from "axios";
export default {
  props: ["users", "settings"],
  data() {
    return {
      game: {
        localOrOnline: settings.localOrOnline,
        id: this.$route.params.id,
        rounds: []
      }
    };
  },
  computed: {
    activeRound() {
      return this.rounds.length - 1;
    }
  },
  methods: {
    winRound(e) {
      this.scores[e.playerId] += e.points;
      this.$store.commit("notify", {
        message: this.users[e.playerId].username + " wins the round!",
        variant: "success"
      });
    },
    loadGame() {
      console.log("Loading game" + this.game.id);
      axios.get("games/" + this.game.id + ".json").then(res => {
        const data = res.data;
        console.log(data);
        this.game.pointsToWin = data.pointsToWin;
        this.game.scores = data.scores;
        this.game.users = data.users;
        this.game.rounds = data.rounds;
        this.$store.commit("notify", {
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
          this.$store.commit("notify", {
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
          this.$store.commit("notify", {
            message: "✓ Round saved",
            variant: "success"
          });
        });
    }
  },
  created() {
    //this.loadGame();
  },
  components: {
    "game-manager": GameManager,
    "game-controls": Controls,
    "game-info": GameInfo,
    "game-tile": Tile
  }
};
</script>
<style lang="scss">

</style>


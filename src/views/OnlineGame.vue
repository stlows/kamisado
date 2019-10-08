<template>
    <div>
        <game-manager v-if="loaded" :game="game"></game-manager> 
    </div>

</template>

<script>
import GameManager from "../components/GameManager.vue";
import axios from "axios";

export default {
  data() {
    return {
        game: null
     }
  },
  created() {
      axios.get("games/" + this.$route.params.id + ".json").then(res => {
          this.game = res.data;
        
        this.$store.commit("notify", {
          message: "✓ Game loaded",
          variant: "success"
        });
      });
  },
  components: {
    "game-manager": GameManager
  }
};
</script>

<style>

</style>
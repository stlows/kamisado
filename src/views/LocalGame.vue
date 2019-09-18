<template>
  <div>
    <game-manager :game="game"></game-manager>
  </div>
</template>

<script>
import GameManager from "../components/GameManager.vue";
export default {
  computed: {
    game(){
      return this.$store.getters.activeGame;
    }
  },
  components: {
    "game-manager": GameManager
  }
};
</script>


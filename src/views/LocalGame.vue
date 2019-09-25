<template>
  <div>
    <game-manager :game="game"></game-manager>
  </div>
</template>

<script>
import GameManager from "../components/GameManager.vue";
export default {
  computed: {
    game() {
      return this.$store.getters.gameById(this.$route.params.id);
    }
  },
  components: {
    "game-manager": GameManager
  }
};
</script>

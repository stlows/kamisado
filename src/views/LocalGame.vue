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
      return this.$store.state.localGames.find(x=> x.id === this.$attrs.id);
    }
  },
  components: {
    "game-manager": GameManager
  }
};
</script>


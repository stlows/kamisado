<template>
  <div>
    <!-- <game-info :game="game"></game-info>
    <game-controls @moveConfirmed="moveConfirmed" :game="game"></game-controls>
    <game-board @notify="notify" @save-round="saveRound" @winRound="winRound" :game="game"></game-board>-->
    <game-manager :users="users" :settings="settings"></game-manager>
  </div>
</template>

<script>
import GameManager from "../components/GameManager.vue";
export default {
  props: ["users", "settings"],
  components: {
    "game-manager": GameManager
  }
};
</script>


<template>
  <div>
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


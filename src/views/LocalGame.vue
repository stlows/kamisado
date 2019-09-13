<template>
  <div>
    <game-manager :users="users" :settings="settings" :tiles="tiles"></game-manager>
  </div>
</template>

<script>
import GameManager from "../components/GameManager.vue";
export default {
  data(){
    return {
      tiles: null
    }
  },
  props: ["users", "settings", "id"],
  methods:{
    loadGame(){
      let game = this.$store.state.localGames.find(g=>g.id === this.id);
      this.tiles = game.tiles;
    }
  },
  created(){
    this.loadGame();
  },
  components: {
    "game-manager": GameManager
  }
};
</script>


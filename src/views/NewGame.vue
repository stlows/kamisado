<template>
  <div id="newGame">
    <v-card class="pa-6 mx-auto" max-width="300">
      <h2 class="mb-6">New game</h2>
      <v-form>
        <v-select
          label="Points to win"
          :items="pointsToWinOptions"
          v-model="settings.pointsToWin"
          max-width="250"
          outlined
        ></v-select>
      </v-form>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="onSubmit" color="success" text>Create game !</v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import InitialTiles from "../assets/InitialTiles.json";
import { getTilesCopy, getUsersCopy } from "../copier.js";
import { mapActions } from "vuex";

export default {
  data() {
    return {
      pointsToWinOptions: [1, 3, 7, 15],
      settings: {
        //localOrOnline: "online",
        //aiOrHuman: "human",
        pointsToWin: 3
      }
    };
  },
  methods: {
    ...mapActions(["newLobby", "notify"]),
    onSubmit(evt) {
      evt.preventDefault();
      this.newLobby(this.settings.pointsToWin).then(res => {
        if (res.data.error) {
          this.notify({
            variant: "error",
            message: res.data.message
          });
        } else {
          this.notify({
            variant: "success",
            message: "Lobby created"
          });
        }
        this.$emit("refreshLobby");
      });
    }
  }
};
</script>

<style lang="scss">
</style>

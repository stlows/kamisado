<template>
  <div id="newGame">
    <div class="card new-game">
      <div class="card-header">
        <h3>New game</h3>
      </div>
      <div class="card-body">
        <b-form @submit="onSubmit">
          <!-- <b-form-group label="Local or online">
            <b-form-radio
              v-model="settings.localOrOnline"
              name="localOrOnlineRadio"
              value="local"
            >Local</b-form-radio>
            <b-form-radio
              v-model="settings.localOrOnline"
              name="localOrOnlineRadio"
              value="online"
            >Online</b-form-radio>
          </b-form-group>-->
          <!-- <b-form-group label="Vs Human or computer?" v-if="settings.localOrOnline === 'local'">
            <b-form-radio v-model="settings.aiOrHuman" name="aiOrHumanRadio" value="human">Human</b-form-radio>
            <b-form-radio
              v-model="settings.aiOrHuman"
              name="aiOrHumanRadio"
              value="ai"
              disabled
              title="Not yet implemented..."
            >Computer</b-form-radio>
          </b-form-group>
          <hr />-->
          <b-form-group label="Points to win:">
            <b-form-select v-model="settings.pointsToWin" :options="pointsToWinOptions"></b-form-select>
          </b-form-group>
          <b-button type="submit" variant="primary">Create game !</b-button>
        </b-form>
      </div>
    </div>
  </div>
</template>

<script>
import InitialTiles from "../assets/InitialTiles.json";
import { getTilesCopy, getUsersCopy } from "../copier.js";
import Settings from "../models/Settings";
import Game from "../models/Game";
import Utils from "../models/Utils";
import Notification from "../models/Notification";
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
        this.$emit("refreshLobby");
        this.notify({
          id: new Date().valueOf(),
          variant: "success",
          message: "Lobby created"
        });
      });
    }
  }
};
</script>

<style lang="scss">
</style>

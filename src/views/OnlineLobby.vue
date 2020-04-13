<template>
  <div class="lobby">
    <div class="card lobby-container">
      <div class="card-header">
        <h3>Lobby</h3>
        <a href="#" @click.prevent="refreshLobby">Refresh</a>
      </div>
      <div class="card-body">
        <template v-if="loading">
          <p>Loading...</p>
        </template>
        <template v-else>
          <template v-if="games.length > 0">
            <b-table :items="games" :fields="fields">
              <template v-slot:cell(lobby_id)="data">
                <a href="#" class="joinGameLink" @click.prevent="joinGame(data)">Join</a>
              </template>
            </b-table>
          </template>
          <template v-else>
            <p>No lobby</p>
          </template>
        </template>
      </div>
      <!-- <div class="card-footer">
        <button class="btn btn-large btn-primary" @click="newLobby">New Game</button>
      </div>-->
    </div>
  </div>
</template>


<script>
import { Component, Vue } from "vue-property-decorator";
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      fields: [
        "player_name",
        "points_to_win",
        { key: "lobby_id", label: "Link" }
      ],
      games: [],
      loading: true
    };
  },
  methods: {
    ...mapActions(["getLobby", "newGame", "deleteLobby", "notify"]),
    refreshLobby() {
      this.loading = true;
      this.getLobby().then(res => {
        this.games = res.data;
        this.loading = false;
      });
    },
    newLobby() {
      this.$router.push({ path: "/newGame" });
    },
    joinGame(data) {
      this.newGame(parseInt(data.value)).then(res => {
        if (res.data.error) {
          this.notify({
            id: new Date().valueOf(),
            variant: "danger",
            message: res.data.message
          });
        } else {
          this.deleteLobby(parseInt(data.value)).then(res => {
            this.refreshLobby();
          });
          this.$router.push({ path: "/online/game/" + res.data });
          this.$emit("lobbyJoined");
        }
      });
    }
  },
  created() {
    this.refreshLobby();
  }
};
</script>

<style>
.lobby-container {
  max-width: 800px;
  margin: 50px auto;
}
</style>


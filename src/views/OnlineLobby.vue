<template>
  <div class="lobby">
    <v-card class="px-6 py-3">
      <div class="d-flex justify-space-between mb-3">
        <h2>Lobby</h2>
        <v-spacer></v-spacer>
        <v-btn href="#" @click.prevent="refreshLobby" color="info" text>Refresh</v-btn>
      </div>
      <v-data-table :loading="loading" :items="lobbies" :headers="headers" disable-sort>
        <template v-slot:item.lobby_id="{ item }">
          <v-btn text color="success" @click="joinGame(item.lobby_id)">Join</v-btn>
        </template>
      </v-data-table>
    </v-card>
  </div>
</template>


<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      headers: [
        { text: "Player", value: "username" },
        { text: "Points", value: "points_to_win", align: "center", width: 50 },
        { text: "Join", value: "lobby_id", align: "center", width: 50 }
      ],
      lobbies: [],
      loading: false
    };
  },
  methods: {
    ...mapActions(["getLobby", "newGame", "deleteLobby", "notify"]),
    refreshLobby() {
      this.loading = true;
      this.getLobby().then(res => {
        this.lobbies = res.data;
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
            variant: "error",
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


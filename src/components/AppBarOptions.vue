<template>
  <v-menu offset-y>
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on" class="ml-3">
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </template>

    <v-list>
      <v-list-item>
        <v-switch v-model="darkMode" label="Dark mode"></v-switch>
      </v-list-item>
      <v-list-item-group v-if="isSignedIn">
        <v-divider></v-divider>
        <v-list-item>
          <v-list-item-content @click="logout">Log out</v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content @click="$router.push('profile')">Profile</v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-menu>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      darkMode: true
    };
  },
  computed: {
    ...mapGetters(["isSignedIn"])
  },
  methods: {
    ...mapActions(["checkIsSignedIn"]),
    logout() {
      localStorage.removeItem("token");
      this.checkIsSignedIn();
    }
  },
  watch: {
    darkMode() {
      this.$vuetify.theme.dark = this.darkMode;
    }
  }
};
</script>

<style>
</style>
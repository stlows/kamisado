<template>
  <v-app>
    <app-bar dark></app-bar>

    <v-content>
      <router-view />
    </v-content>
    <notifications-panel></notifications-panel>
  </v-app>
</template>

<script>
import AppBar from "./components/AppBar";
import NotificationsPanel from "./components/NotificationsPanel";
import Vue from "vue";

export default {
  components: {
    "app-bar": AppBar,
    "notifications-panel": NotificationsPanel
  },
  data: () => ({
    //
  })
};
</script>

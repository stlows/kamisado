<template>
  <v-app-bar app>
    <v-toolbar-title>가미 사도 &mdash; Kamisado</v-toolbar-title>
    <div class="ml-6">
      <v-btn text @click="$router.push('/')">Home</v-btn>
    </div>

    <v-spacer></v-spacer>
    <template v-if="isSignedIn">You are logged in !</template>
    <template v-else>
      <LoginRegister />
    </template>
    <AppBarOptions />
  </v-app-bar>
</template>

<script>
import LoginRegister from "./LoginRegister";
import AppBarOptions from "./AppBarOptions";
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {
      darkMode: true
    };
  },
  components: {
    LoginRegister,
    AppBarOptions
  },
  computed: {
    ...mapGetters({ isSignedIn: "isSignedIn" })
  },
  methods: {
    ...mapActions(["checkIsSignedIn"])
  },
  mounted() {
    this.checkIsSignedIn();
  },
  watch: {
    darkMode() {
      this.$vuetify.theme.dark = this.darkMode;
    }
  }
};
</script>

<style lang="scss">
.home-link {
  margin-top: 5px;
  margin-left: 5px;
  padding: 5px 10px;
  display: inline-block;
  border-radius: 10px;
  &:hover {
    background-color: #fafafa;
  }
}
</style>
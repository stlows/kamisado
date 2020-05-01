<template>
  <div class="mt-12 text-center">
    <h1>
      Welcome
      <span v-if="isSignedIn">back</span> to Kamisado
    </h1>
    <div class="my-12">
      <LoginRegister v-if="!isSignedIn" />
      <v-btn v-else color="info">Go to your Home</v-btn>
    </div>
    <v-img src="@/assets/game.png" max-width="500" class="mx-auto"></v-img>
  </div>
</template>

<script>
import LoginRegister from "../components/LoginRegister";
import { mapGetters } from "vuex";

export default {
  components: {
    LoginRegister
  },
  computed: {
    ...mapGetters(["isSignedIn"])
  }
};
</script>

<style>
</style>

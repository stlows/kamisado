<template>
  <div class="mt-12 text-center">
    <h1>Welcome to Kamisado</h1>
    <div class="my-12">
      <LoginRegister />
    </div>
    <v-img src="@/assets/game.png" max-width="500" class="mx-auto"></v-img>
  </div>
</template>

<script>
import LoginRegister from "../components/LoginRegister";

export default {
  components: {
    LoginRegister
  }
};
</script>

<style>
</style>

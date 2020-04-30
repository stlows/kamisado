<template>
  <div class="d-flex align-center justify-center" style="height: 100%">
    <v-card min-width="500" class="py-6 px-12">
      <h1 class="mb-6">Verify your account</h1>
      <v-form @submit="submit">
        <v-text-field
          label="Enter the code"
          v-model="code"
          outlined
          @keyup.enter="submit"
          :disabled="disabled"
        ></v-text-field>
      </v-form>

      <div class="text-center">
        <v-alert type="error" v-if="errorMessage">{{errorMessage}}</v-alert>
        <v-btn @click="submit" color="info" :disabled="disabled" tabindex="3" class="mb-3">Verify</v-btn>
      </div>
    </v-card>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: ["username"],
  data() {
    return {
      disabled: false,
      errorMessage: ""
    };
  },
  methods: {
    ...mapActions(["verify"]),
    submit() {
      this.disabled = true;

      var credentials = {
        username: this.username,
        code: this.code
      };
      this.verify(credentials)
        .then(res => {
          console.log(res);
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.$router.push(`/login`);
          }
        })
        .finally(() => {
          this.disabled = false;
        });
    }
  }
};
</script>

<style>
</style>
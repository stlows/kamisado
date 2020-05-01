<template>
  <div class="d-flex align-center justify-center" style="height: 100%">
    <v-card min-width="400" class="py-6 px-12">
      <h1 class="mb-6">Login</h1>
      <v-form @submit="submit">
        <v-text-field
          class="dark"
          label="E-mail or Username"
          v-model="form.email"
          outlined
          @keyup.enter="tab = 'password-tab'"
          clearable
          tabindex="1"
          :disabled="disabled"
        ></v-text-field>
        <v-text-field
          label="Password"
          v-model="form.password"
          outlined
          @keyup.enter="submit"
          clearable
          :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showPassword ? 'text' : 'password'"
          @click:append="showPassword = !showPassword"
          tabindex="2"
          :disabled="disabled"
        ></v-text-field>
      </v-form>

      <div class="text-center">
        <v-alert type="error" v-if="errorMessage">{{errorMessage}}</v-alert>
        <v-btn @click="submit" color="info" :disabled="disabled" tabindex="3" class="mb-3">Login</v-btn>
        <p class="mb-0">
          Don't have an account?
          <a @click.prevent="$router.push('/register')">Register here</a>
        </p>
        <p>
          <a @click.prevent="$router.push('/forgot')">Forgot your password?</a>
        </p>
      </div>
    </v-card>
  </div>
</template>

<script>
import { mapActions, mapMutations } from "vuex";

export default {
  data() {
    return {
      tab: "email-tab",
      showPassword: false,
      disabled: false,
      form: {
        email: "",
        password: ""
      },
      errorMessage: ""
    };
  },
  methods: {
    ...mapActions(["login", "checkIsSignedIn"]),
    submit() {
      this.disabled = true;

      this.login(this.form)
        .then(res => {
          if (res.data.error || !res.data) {
            if (res.data.message) {
              this.errorMessage = res.data.message;
            } else {
              this.errorMessage = "Wrong credentials";
            }
          } else {
            var token = btoa(this.form.email + ":" + this.form.password);
            localStorage.setItem("token", token);
            this.checkIsSignedIn();
            this.$router.push("/");
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
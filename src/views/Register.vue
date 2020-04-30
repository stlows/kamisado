<template>
  <div class="d-flex align-center justify-center" style="height: 100%">
    <v-card min-width="500" class="py-6 px-12">
      <h1 class="mb-6">Create an account</h1>
      <v-form @submit="submit">
        <v-text-field
          label="E-mail"
          v-model="form.email"
          outlined
          @keyup.enter="tab = 'password-tab'"
          clearable
          tabindex="1"
          :disabled="disabled"
          :rules="emailRules"
        ></v-text-field>
        <v-text-field
          label="Username"
          v-model="form.username"
          outlined
          @keyup.enter="tab = 'password-tab'"
          clearable
          tabindex="2"
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
          tabindex="3"
          :disabled="disabled"
        ></v-text-field>
        <v-text-field
          label="Validate password"
          v-model="form.validatePassword"
          outlined
          @keyup.enter="submit"
          clearable
          :append-icon="showValidatePassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showValidatePassword ? 'text' : 'password'"
          @click:append="showValidatePassword = !showValidatePassword"
          tabindex="4"
          :disabled="disabled"
        ></v-text-field>
      </v-form>

      <div class="text-center">
        <v-alert type="error" v-if="errorMessage">{{errorMessage}}</v-alert>
        <v-btn
          @click="submit"
          color="info"
          :disabled="disabled"
          tabindex="5"
          class="mb-3"
        >Create an account</v-btn>
        <p class="mb-0">
          Already have an account?
          <a @click.prevent="$router.push('/login')">Login here</a>
        </p>
      </div>
    </v-card>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      tab: "email-tab",
      showPassword: false,
      showValidatePassword: false,
      disabled: false,
      emailRules: [
        v => !!v || "E-mail is required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      form: {
        email: "",
        username: "",
        password: "",
        validatePassword: ""
      },
      errorMessage: ""
    };
  },
  methods: {
    ...mapActions(["register"]),
    submit() {
      this.disabled = true;
      if (this.form.password !== this.form.validatePassword) {
        this.errorMessage = "Entered passwords do not match";
        this.disabled = false;
        return;
      }

      var credentials = {
        username: this.form.username,
        email: this.form.email,
        password: this.form.password
      };
      this.register(credentials)
        .then(res => {
          if (res.data.error) {
            this.errorMessage = res.data.message;
          } else {
            this.$router.push(`/verify/${res.data}`);
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
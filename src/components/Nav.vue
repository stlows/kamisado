<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand to="/">가미 사도 &mdash; Kamisado</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/local/lobby">Local lobby</b-nav-item>
          <b-nav-item to="/online/lobby" disabled title="Not yet implemented..."
            >Online lobby</b-nav-item
          >
          <b-nav-item to="/newGame">New game</b-nav-item>
          <b-nav-item to="/tutorial" disabled title="Not yet implemented..."
            >Tutorial</b-nav-item
          >
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
          <b-nav-form>
            <b-form-group label="Login as:" label-cols-lg="4" label-size="sm">
              <b-form-input
                size="sm"
                placeholder="Login as..."
                :value="loginAs"
                @input="updateLogin"
              ></b-form-input>
            </b-form-group>
          </b-nav-form>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <router-link to="/" class="home-link" v-if="showHome"
      >← Go to home
    </router-link>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    showHome() {
      return this.$route.name !== "home";
    },
    ...mapState(["loginAs"])
  },
  methods: {
    updateLogin(updatedLogin) {
      this.$store.commit("updateLogin", updatedLogin);
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

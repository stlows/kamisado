<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand to="/">가미 사도 &mdash; Kamisado</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <!-- <b-nav-item to="/local/lobby" disabled title="Not yet implemented...">Local lobby</b-nav-item> -->
          <b-nav-item to="/online/lobby">Online lobby</b-nav-item>
          <b-nav-item to="/mygames">My Games</b-nav-item>
          <!-- <b-nav-item to="/tutorial" disabled title="Not yet implemented...">Tutorial</b-nav-item> -->
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
          <div id="my-signin2" v-if="!isSignedIn"></div>
          <template v-if="isSignedIn">
            <b-dropdown
              id="dropdown-1"
              variant="outline-primary"
              :text="'Logged in as ' +  name"
              class="m-md-2"
            >
              <b-dropdown-item @click="signout">Sign Out</b-dropdown-item>
            </b-dropdown>
          </template>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <!-- <router-link to="/" class="home-link" v-if="showHome">← Go to home</router-link> -->
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";
export default {
  data() {
    return {
      isSignedIn: false,
      name: ""
    };
  },
  computed: {},
  watch: {
    isSignedIn(newVal) {
      if (!newVal) {
        this.renderSignin();
      }
    }
  },
  created() {
    this.renderSignin();
  },
  methods: {
    ...mapMutations(["setToken"]),
    renderSignin() {
      setTimeout(() => {
        window.gapi.signin2.render("my-signin2", {
          width: 150,
          height: 40,
          longtitle: false,
          theme: "dark",
          onsuccess: this.onSuccess,
          onfailure: this.onFailure
        });
      });
    },
    signout() {
      var auth2 = gapi.auth2.getAuthInstance();
      let vue = this;
      auth2.signOut().then(() => {
        vue.isSignedIn = false;
      });
    },
    onSuccess(googleUser) {
      this.isSignedIn = true;
      var profile = googleUser.getBasicProfile();
      this.name = profile.getName();
      this.setToken(googleUser.getAuthResponse().id_token);
    },
    onFailure(error) {},
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
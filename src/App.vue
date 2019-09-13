<template>
  <div id="app">
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand to="/">가미 사도 &mdash; Kamisado</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/local/lobby">Local lobby</b-nav-item>
          <b-nav-item to="/online/lobby" disabled title="Not yet implemented...">Online lobby</b-nav-item>
          <b-nav-item to="/tutorial" disabled title="Not yet implemented...">Tutorial</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <router-link to="/" class="home-link" v-if="$router.history.current.name !== 'home'">← Go to home </router-link>
    <router-view/>
    <div id="notifications-panel" class="panel">
      <div v-for="notification in notifications" :key="notification.id">
        <b-alert :variant="notification.variant" dismissible :show="2" fade>{{ notification.message }}</b-alert>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {}
  },
  computed: {
    notifications(){
      return this.$store.state.notifications;
    }
  }
};
</script>

<style lang="scss">
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  padding-bottom: 30px;
}
h1.header {
  margin: 30px 0;
  text-align:center;
}
#notifications-panel {
  position: fixed;
  bottom: 0;
  right: 0;
  width: 300px;
  padding-right: 20px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.home-link {
  margin-top: 5px;
  margin-left: 5px;
  padding: 5px 10px;
  display:inline-block;
  border-radius:10px;
  &:hover{
    background-color: #fafafa;
  }
}
</style>

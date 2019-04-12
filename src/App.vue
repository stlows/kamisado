<template>
  <div id="app">
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand to="/">가미 사도 &mdash; Kamisado</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/">Lobby</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <router-view @notify="notify"/>
    <div id="notifications-panel" class="panel">
      <div v-for="notification in notifications" :key="notification.id">
        <b-alert :variant="notification.variant" dismissible :show="2" fade>{{notification.message}}</b-alert>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      notifications: []
    };
  },
  methods: {
    notify(_notification) {
      let notification = {
        message: _notification.message,
        variant:
          typeof _notification.variant === "undefined"
            ? "info"
            : _notification.variant,
        id: "notification" + Date.now()
      };
      this.notifications.push(notification);
    }
  }
};
</script>

<style lang="scss">
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  padding-bottom: 30px;
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
</style>

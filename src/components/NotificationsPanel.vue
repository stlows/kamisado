<template>
  <div id="notifications-panel" class="panel">
    <div v-for="notification in notifications" :key="notification.id">
      <b-alert :variant="notification.variant" dismissible :show="2" fade>{{
        notification.message
      }}</b-alert>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    notifications() {
      return this.$store.state.notifications;
    }
  }
};
</script>

<style scoped lang="scss">
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

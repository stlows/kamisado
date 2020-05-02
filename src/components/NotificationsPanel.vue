<template>
  <div id="notifications-panel">
    <v-snackbar
      v-for="(notification, index) in notifications"
      :key="notification.id"
      :value="notification.value"
      bottom
      left
      :color="notification.variant"
      dismissible
      :timeout="5000"
    >
      {{ notification.message }}
      <v-btn text @click="closeNotification(index)">Close</v-btn>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  computed: {
    notifications() {
      return this.$store.state.notifications;
    }
  },
  methods: {
    closeNotification(index) {
      this.$store.state.notifications.splice(index, 1);
    }
  }
};
</script>

<style scoped lang="scss">
</style>
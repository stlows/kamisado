<template>
  <div id="app">
    <app-nav @onlogin="onlogin" @onlogout="onlogout"></app-nav>
    <template v-if="loggedIn">
      <router-view/>
    </template>
    <template v-else>
      <p>Please login.</p>
    </template>
    <notifications-panel></notifications-panel>
  </div>
</template>
<script>
import Nav from "./components/Nav"
import NotificationsPanel from "./components/NotificationsPanel"
export default {
  data(){
    return {
      loggedIn:false
    }
  },
  components:{
    "app-nav": Nav,
    "notifications-panel": NotificationsPanel
  },
  onlogin(){
    this.loggedIn = true
  },
  onlogout(){
    this.loggedIn = false
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
</style>

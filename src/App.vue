<template>
  <div id="app">
    <b-navbar toggleable="lg" type="light">
      <b-navbar-brand href="#">Kamisado</b-navbar-brand>
      <b-nav-item to="/">Lobby</b-nav-item>
      <b-nav-item to="/game">Game</b-nav-item>
    </b-navbar>
    <router-view/>
  </div>
</template>

<style lang="scss">
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  padding-bottom: 30px;
}
</style>

<template>
  <div id="app">
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand to="/">가미 사도 &mdash; Kamisado</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/">Lobby</b-nav-item>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <!--
    <b-navbar toggleable="lg" type="light">
      <b-navbar-brand href="#">Kamisado</b-navbar-brand>
      <b-nav-item to="/">Lobby</b-nav-item>
      <b-nav-item to="/game">Game</b-nav-item>
    </b-navbar>
    -->
    <router-view/>
  </div>
</template>

<style lang="scss">
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  padding-bottom: 30px;
}
</style>

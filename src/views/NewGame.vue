<template>
    <div id="newGame">
    <h1 class="header">New game</h1>
        <b-form @submit="onSubmit">
        <b-form-group label="Player 1 (black):">
            <b-form-input v-model="users[0].username" placeholder="Username" class="mb-3"></b-form-input>
            <b-form-input v-model="users[0].name" placeholder="Name"></b-form-input>
        </b-form-group>
        <hr>
        <b-form-group label="Player 2 (white):">
            <b-form-input v-model="users[1].username" placeholder="Username" class="mb-3"></b-form-input>
            <b-form-input v-model="users[1].name" placeholder="Name"></b-form-input>
        </b-form-group>
        <hr>
        <b-form-group label="Local or online">
            <b-form-radio v-model="settings.localOrOnline" name="localOrOnlineRadio" value="local">Local</b-form-radio>
            <b-form-radio v-model="settings.localOrOnline" name="localOrOnlineRadio" value="online" disabled title="Not yet implemented...">Online</b-form-radio>
        </b-form-group>
        <b-form-group label="Vs Human or computer?" v-if="settings.localOrOnline === 'local'">
            <b-form-radio v-model="settings.aiOrHuman" name="aiOrHumanRadio" value="human">Human</b-form-radio>
            <b-form-radio v-model="settings.aiOrHuman" name="aiOrHumanRadio" value="ai" disabled title="Not yet implemented...">Computer</b-form-radio>
        </b-form-group>
        <hr>
        <b-form-group label="Points to win:">
            <b-form-select v-model="settings.pointsToWin" :options="pointsToWinOptions"></b-form-select>
        </b-form-group>

        <b-button type="submit" variant="primary">Create game !</b-button>
    </b-form>
    </div>
</template>

<script>
import InitialTiles from "../assets/InitialTiles.json";
import { getTilesCopy, getUsersCopy } from "../copier.js";

export default {
    data(){
        return {
            pointsToWinOptions: [1, 3, 7, 15],
            settings: {
                localOrOnline: 'local',
                aiOrHuman: 'human',
                pointsToWin: 15
            },
            users:[
                { username: this.$store.state.loginAs, name: "Charles", score: 0, color: "white" },
                { username: "vbeaulieu", name: "Vincent", score: 0, color: "black" }
            ]
            
        }
    },
    methods: {
      onSubmit(evt) {
        evt.preventDefault()
        let id = Date.now();
        if(this.settings.localOrOnline === 'local'){
            let newGame = {
                users: getUsersCopy(this.users),
                settings: this.settings,
                tiles: getTilesCopy(InitialTiles),
                id: id,
                playersTurn: "white"
            }
            this.$store.commit("addLocalGame", newGame);
        }
        this.$store.commit('notify', {
          message: "✓ New game created locally",
          variant: "success"
        })

        this.$router.push({
            name: "local/game",
            params: { id: id }
        })
      }      
    }
}
</script>

<style lang="scss">
    #newGame{
        margin:0 25%;
    }
</style>
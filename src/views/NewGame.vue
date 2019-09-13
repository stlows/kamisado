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
            <b-form-radio v-model="localOrOnline" name="localOrOnlineRadio" value="local">Local</b-form-radio>
            <b-form-radio v-model="localOrOnline" name="localOrOnlineRadio" value="online" disabled title="Not yet implemented...">Online</b-form-radio>
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
export default {
    data(){
        return {
            pointsToWinOptions: [1, 3, 7, 15],
            settings: {
                localOrOnline: '',
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

        this.$store.commit('notify', {
          message: "✓ New game created locally",
          variant: "success"
        })

        this.$router.push({
            name: "local/game",
            params: { users: this.users, settings: this.settings }
        });
      }      
    }
}
</script>

<style lang="scss">
    #newGame{
        margin:0 25%;
    }
</style>
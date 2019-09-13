<template>
    <div id="settings">
    <h1 class="header">Settings</h1>
        <b-form @submit="onSubmit">
        <b-form-group label="Player 1:">
            <b-form-input v-model="users[0].username" placeholder="Username"></b-form-input>
            <b-form-input v-model="users[0].name" placeholder="Name"></b-form-input>
            <b-form-input v-model="users[0].score" placeholder="Score"></b-form-input>
            <b-form-input v-model="users[0].color" placeholder="Color"></b-form-input>
        </b-form-group>
        <b-form-group label="Player 2:">
            <b-form-input v-model="users[1].username" placeholder="Username"></b-form-input>
            <b-form-input v-model="users[1].name" placeholder="Name"></b-form-input>
            <b-form-input v-model="users[1].score" placeholder="Score"></b-form-input>
            <b-form-input v-model="users[1].color" placeholder="Color"></b-form-input>
        </b-form-group>
    
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
            pointsToWinOptions: [1,3,7,15],
            settings: {
                pointsToWin: 15
            },
            users:[
                { username: "cprovost", name: "Charles", score: 0, color: "white" },
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
    #settings{
        margin:0 25%;
    }
</style>
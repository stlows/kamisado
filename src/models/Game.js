export default class Game {
    constructor() {
        this.players = [new Player("Vincent"), new Player("Charles")]
        this.rounds = [new Round(this.players)];
    }
}
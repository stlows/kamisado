export default class User {
    username : string;
    name : string;
    score : Number;
    color : string;

    constructor(username : string, name : string, color : string) {
        this.username = username;
        this.name = name;
        this.score = 0;
        this.color = color;
    }
}
import User from './User';
import Settings from './Settings';
import Tile from './Tile';

export default class Game {

    users: User[];
    settings: Settings;
    tiles: Tile[];
    id: Number;
    playersTurn: string;
    
    constructor(users: User[], settings: Settings, tiles : Tile[], id: Number, playersTurn : string) {
        this.users = users;
        this.settings = settings;
        this.tiles = tiles;
        this.id = id;
        this.playersTurn = playersTurn
    }
}

import Tile from "./Tile"
import Tower from "./Tower"

export default class Utils {

    getInitialtiles() {
        let tiles : Tile[] = [];
        for(let y = 0; y < 8; y++){
            for(let x = 0; x < 8; x++){
                let tileColor = this.tileColors[y][x];
                let tower = y === 0 ? (new Tower(tileColor, "white")) : (y === 7 ? new Tower(tileColor, "black") : undefined)
                let tile  = new Tile(x, y, tileColor, tower)
                tiles.push(tile);
            }
        }
        return tiles;
    }

    tileColors : string[][] = [
        ["orange", "blue", "indigo", "pink", "yellow", "red", "green", "brown"],
        ["red","orange","pink","green","blue","yellow","brown","indigo"],
        ["green","pink","orange","red","indigo","brown","yellow","blue"],
        ["pink", "indigo","blue", "orange","brown","green","red","yellow"],
        ["yellow","red", "green","brown","orange","blue","indigo","pink"],
        ["blue", "yellow","brown","indigo","red","orange","pink","green"],
        ["indigo","brown","yellow","blue","green","pink","orange","red"],
        ["brown", "green", "red", "yellow", "pink", "indigo", "blue", "orange"]
    ]

}
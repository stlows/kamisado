import Tower from "./Tower"

export default class Tile {
    x: number;
    y: number;
    color: string;
    selectable: boolean;
    tower?: Tower;
      
    constructor(x : number, y : number, color : string, tower?: Tower) {
        this.x = x;
        this.y = y;
        this.color = color;
        this.selectable = false;
        this.tower = tower;
    }
}
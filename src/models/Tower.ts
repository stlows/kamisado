export default class Tower {
    color: string;
    playerColor: string;
    selectable: boolean;
    selected: boolean;
    sumo: number;
    constructor(color: string, playerColor: string) {
        this.color = color;
        this.playerColor = playerColor;
        this.selectable = false;
        this.selected = false;
        this.sumo = 0;
    }
}
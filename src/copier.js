export function getTowerCopy(tower){
    let copy = {};
    copy.color = tower.color;
    copy.playerColor = tower.playerColor;
    copy.selectable = tower.selectable;
    copy.selected = tower.selected;
    copy.sumo = tower.sumo;
    return copy;
}

export function getTileCopy(tile){
    let copy = {};
    copy.x = tile.x;
    copy.y = tile.y;
    copy.color = tile.color;
    copy.selectable = tile.selectable;
    if (tile.tower) {
      copy.tower = this.getTowerCopy(tile.tower);
    }
    return copy;
}
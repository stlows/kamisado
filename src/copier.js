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
      copy.tower = getTowerCopy(tile.tower);
    }
    return copy;
}

export function getTilesCopy(tiles){
    let copy = [];
    for(let i = 0; i < tiles.length; i++){
        copy.push(getTileCopy(tiles[i]));
    }
    return copy;
}


export function getUsersCopy(users){
    let copy = [];
    for(let i = 0; i < users.length; i++){
        copy.push(getUserCopy(users[i]));
    }
    return copy;
}

export function getUserCopy(user){
    let copy = {};
    copy.username = user.username;
    copy.name = user.name;
    copy.score = user.score;
    copy.color = user.color;
    return copy;
}
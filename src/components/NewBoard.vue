<template>
  <div>
    <div id="board">
      <game-tile
        v-for="tile in tiles"
        :key="tile.x + '_' + tile.y"
        :tile="tile"
        @towerClicked="towerClicked"
        @tileClicked="tileClicked"
      ></game-tile>
    </div>
  </div>
</template>

<script>
import Tile from "../components/Tile.vue";

export default {
  data() {
    return {
      playersTurn: "white",
      tiles: [
        {
          x: 0,
          y: 0,
          color: "orange",
          selectable: false,
          tower: {
            color: "orange",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 1,
          y: 0,
          color: "blue",
          selectable: false,
          tower: {
            color: "blue",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 2,
          y: 0,
          color: "indigo",
          selectable: false,
          tower: {
            color: "indigo",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 3,
          y: 0,
          color: "pink",
          selectable: false,
          tower: {
            color: "pink",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 4,
          y: 0,
          color: "yellow",
          selectable: false,
          tower: {
            color: "yellow",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 5,
          y: 0,
          color: "red",
          selectable: false,
          tower: {
            color: "red",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 6,
          y: 0,
          color: "green",
          selectable: false,
          tower: {
            color: "green",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        {
          x: 7,
          y: 0,
          color: "brown",
          selectable: false,
          tower: {
            color: "brown",
            playerColor: "white",
            selectable: false,
            selected: false
          }
        },
        { x: 0, y: 1, color: "red", selectable: false, tower: null },
        { x: 1, y: 1, color: "orange", selectable: false, tower: null },
        { x: 2, y: 1, color: "pink", selectable: false, tower: null },
        { x: 3, y: 1, color: "green", selectable: false, tower: null },
        { x: 4, y: 1, color: "blue", selectable: false, tower: null },
        { x: 5, y: 1, color: "yellow", selectable: false, tower: null },
        { x: 6, y: 1, color: "brown", selectable: false, tower: null },
        { x: 7, y: 1, color: "indigo", selectable: false, tower: null },
        { x: 0, y: 2, color: "green", selectable: false, tower: null },
        { x: 1, y: 2, color: "pink", selectable: false, tower: null },
        { x: 2, y: 2, color: "orange", selectable: false, tower: null },
        { x: 3, y: 2, color: "red", selectable: false, tower: null },
        { x: 4, y: 2, color: "indigo", selectable: false, tower: null },
        { x: 5, y: 2, color: "brown", selectable: false, tower: null },
        { x: 6, y: 2, color: "yellow", selectable: false, tower: null },
        { x: 7, y: 2, color: "blue", selectable: false, tower: null },
        { x: 0, y: 3, color: "pink", selectable: false, tower: null },
        { x: 1, y: 3, color: "indigo", selectable: false, tower: null },
        { x: 2, y: 3, color: "blue", selectable: false, tower: null },
        { x: 3, y: 3, color: "orange", selectable: false, tower: null },
        { x: 4, y: 3, color: "brown", selectable: false, tower: null },
        { x: 5, y: 3, color: "green", selectable: false, tower: null },
        { x: 6, y: 3, color: "red", selectable: false, tower: null },
        { x: 7, y: 3, color: "yellow", selectable: false, tower: null },
        { x: 0, y: 4, color: "yellow", selectable: false, tower: null },
        { x: 1, y: 4, color: "red", selectable: false, tower: null },
        { x: 2, y: 4, color: "green", selectable: false, tower: null },
        { x: 3, y: 4, color: "brown", selectable: false, tower: null },
        { x: 4, y: 4, color: "orange", selectable: false, tower: null },
        { x: 5, y: 4, color: "blue", selectable: false, tower: null },
        { x: 6, y: 4, color: "indigo", selectable: false, tower: null },
        { x: 7, y: 4, color: "pink", selectable: false, tower: null },
        { x: 0, y: 5, color: "blue", selectable: false, tower: null },
        { x: 1, y: 5, color: "yellow", selectable: false, tower: null },
        { x: 2, y: 5, color: "brown", selectable: false, tower: null },
        { x: 3, y: 5, color: "indigo", selectable: false, tower: null },
        { x: 4, y: 5, color: "red", selectable: false, tower: null },
        { x: 5, y: 5, color: "orange", selectable: false, tower: null },
        { x: 6, y: 5, color: "pink", selectable: false, tower: null },
        { x: 7, y: 5, color: "green", selectable: false, tower: null },
        { x: 0, y: 6, color: "indigo", selectable: false, tower: null },
        { x: 1, y: 6, color: "brown", selectable: false, tower: null },
        { x: 2, y: 6, color: "yellow", selectable: false, tower: null },
        { x: 3, y: 6, color: "blue", selectable: false, tower: null },
        { x: 4, y: 6, color: "green", selectable: false, tower: null },
        { x: 5, y: 6, color: "pink", selectable: false, tower: null },
        { x: 6, y: 6, color: "orange", selectable: false, tower: null },
        { x: 7, y: 6, color: "red", selectable: false, tower: null },
        {
          x: 0,
          y: 7,
          color: "brown",
          selectable: false,
          tower: {
            color: "brown",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 1,
          y: 7,
          color: "green",
          selectable: false,
          tower: {
            color: "green",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 2,
          y: 7,
          color: "red",
          selectable: false,
          tower: {
            color: "red",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 3,
          y: 7,
          color: "yellow",
          selectable: false,
          tower: {
            color: "yellow",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 4,
          y: 7,
          color: "pink",
          selectable: false,
          tower: {
            color: "pink",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 5,
          y: 7,
          color: "indigo",
          selectable: false,
          tower: {
            color: "indigo",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 6,
          y: 7,
          color: "blue",
          selectable: false,
          tower: {
            color: "blue",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        },
        {
          x: 7,
          y: 7,
          color: "orange",
          selectable: false,
          tower: {
            color: "orange",
            playerColor: "black",
            selectable: false,
            selected: false
          }
        }
      ]
    };
  },
  methods: {
    towerClicked(tile) {
      if (tile.tower.selectable && tile.tower === this.getSelectedTower()) {
        this.unselectTower(tile.tower);
      } else if (tile.tower.selectable) {
        this.selectTower(tile.tower);
      }
    },
    switchPlayer() {
      this.playersTurn = this.playersTurn === "white" ? "black" : "white";
    },
    tileClicked(tile) {
      if (tile.selectable) {
        let color = this.moveTower(this.getSelectedTower(), tile);
        this.unselectTower(this.getSelectedTower());
        this.setPropertyToTowers(this.getTowers(), "selectable", false);
        this.switchPlayer();
        this.selectTower(this.getTower(this.playersTurn, color));
      }
    },
    moveTower(tower, targetTile) {
      let copy = {};
      for (var attr in tower) {
        copy[attr] = tower[attr];
      }
      this.getTileByTower(tower).tower = null;
      targetTile.tower = copy;
      return targetTile.color;
    },
    unsetPossibleTiles() {
      for (var i = 0; i < this.tiles.length; i++) {
        this.tiles[i].selectable = false;
      }
    },
    nextY(y, playerColor) {
      return playerColor === "white" ? y + 1 : y - 1;
    },
    setPossibleTiles() {
      this.unsetPossibleTiles();

      if (!this.getSelectedTower()) {
        return;
      }
      this.setPossibleTilesVertically(this.getSelectedTower());
      this.setPossibleTilesDiagonnally(this.getSelectedTower(), 1);
      this.setPossibleTilesDiagonnally(this.getSelectedTower(), -1);
    },
    inBound(x, y) {
      return x >= 0 && x <= 7 && y >= 0 && y <= 7;
    },
    setPossibleTilesVertically(tower) {
      let tile = this.getTileByTower(tower);
      let y = this.nextY(tile.y, tower.playerColor);
      while (this.inBound(tile.x, y) && !this.getTileByCoord(tile.x, y).tower) {
        this.getTileByCoord(tile.x, y).selectable = true;
        y = this.nextY(y, tower.playerColor);
      }
    },
    setPossibleTilesDiagonnally(tower, deltaX) {
      let tile = this.getTileByTower(tower);
      let x = tile.x + deltaX;
      let y = this.nextY(tile.y, tower.playerColor);
      while (this.inBound(x, y) && !this.getTileByCoord(x, y).tower) {
        this.getTileByCoord(x, y).selectable = true;
        y = this.nextY(y, tower.playerColor);
        x = x + deltaX;
      }
    },
    setPropertyToTower(tower, property, value) {
      tower[property] = value;
    },
    setPropertyToTowers(towers, property, value) {
      for (var i = 0; i < towers.length; i++) {
        this.setPropertyToTower(towers[i], property, value);
      }
    },
    unselectTower(tower) {
      tower.selected = false;
      this.unsetPossibleTiles();
    },
    selectTower(tower) {
      let selectedTower = this.getSelectedTower();
      if (selectedTower) {
        selectedTower.selected = false;
      }
      tower.selected = true;
      this.setPossibleTiles();
    },
    getSelectedTower() {
      return this.getTowers().filter(t => t.selected)[0];
    },
    getPlayerTowers(playerColor) {
      let towers = this.getTowers();
      return towers.filter(t => t.playerColor === playerColor);
    },
    getTileByCoord(x, y) {
      return this.tiles.filter(t => t.x === x && t.y === y)[0];
    },
    getTileByTower(tower) {
      return this.tiles.filter(t => t.tower === tower)[0];
    },
    getTowers() {
      return this.tiles.filter(t => t.tower).map(t => t.tower);
    },
    getTower(playerColor, color) {
      let playerTowers = this.getPlayerTowers(playerColor);
      return playerTowers.filter(t => t.color === color)[0];
    }
  },
  components: {
    "game-tile": Tile
  },
  created() {
    this.setPropertyToTowers(
      this.getPlayerTowers(this.playersTurn),
      "selectable",
      "true"
    );
  }
};
</script>

<style lang="scss">
@import "../assets/constants.scss";
#board {
  display: grid;
  grid-template-columns: repeat(8, $tile-size);
  grid-auto-columns: auto;
  width: 8 * $tile-size;
  margin: auto;
}
</style>

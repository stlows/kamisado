<template>
  <div id="gameManager">
    <game-info
      :users="game.users"
      :playersTurn="game.playersTurn"
      :id="game.id"
    ></game-info>
    <game-board
      :playersTurn="game.playersTurn"
      :tiles="game.tiles"
      @towerClicked="towerClicked"
      @tileClicked="tileClicked"
    ></game-board>
  </div>
</template>

<script>
import Board from "./NewBoard.vue";
import GameInfo from "./GameInfo.vue";
import { getTowerCopy, getTileCopy } from "../copier.js";
//import InitialTiles from "../assets/InitialTiles.json";

export default {
  components: {
    "game-board": Board,
    "game-info": GameInfo
  },
  props: ["game"],
  data() {
    return {
      pointsBySumo: [1, 1, 3, 7, 15],
      maxTilesBySumo: [8, 5, 3, 1]
    };
  },
  methods: {
    newRound(leftOrRight, winningTower) {
      let winningPlayer = winningTower.playerColor;
      let losingPlayer = winningPlayer === "white" ? "black" : "white";
      this.replaceTowers(winningPlayer);
      this.replaceTowers(losingPlayer);
      this.game.playersTurn = losingPlayer;
      this.setPropertyToTowers(
        this.getPlayerTowers(this.game.playersTurn),
        "selectable",
        "true"
      );
    },
    replaceTowers(playerColor, leftOrRight) {
      // Towers to move
      let playerTowers = this.getPlayerTowers(playerColor);
      let conditionToReplace = function(y) {
        if (playerColor === "white") {
          return y > 0;
        }
        return y < 7;
      };
      let toReplaceTowers = playerTowers.filter(t =>
        conditionToReplace(this.getTileByTower(t).y)
      );
      let vue = this;
      toReplaceTowers.sort(function(t1, t2) {
        let tile1 = vue.getTileByTower(t1);
        let tile2 = vue.getTileByTower(t2);
        return tile1.y * 10 + tile1.x - tile2.y * 10 - tile2.x;
      });

      // Empty tiles on home row
      let conditionEmptyHome = function(tile) {
        if (tile.tower) {
          return false;
        }
        return tile.y === (playerColor === "white" ? 0 : 7);
      };
      let emptyHomeTiles = this.game.tiles.filter(t => conditionEmptyHome(t));
      let homeSorting = function(tile1, tile2) {
        if (
          (playerColor === "white" && leftOrRight === "left") ||
          (playerColor === "black" && leftOrRight === "right")
        ) {
          tile1.x - tile2.x;
        }
        return tile2.x - tile1.x;
      };
      emptyHomeTiles.sort(homeSorting);

      // Moving
      for (var i = 0; i < toReplaceTowers.length; i++) {
        this.moveTower(toReplaceTowers[i], emptyHomeTiles[i]);
      }
    },
    towerClicked(tile) {
      if (tile.tower.selectable && tile.tower === this.getSelectedTower()) {
        this.unselectTower(tile.tower);
      } else if (tile.tower.selectable) {
        this.selectTower(tile.tower);
      }
    },
    switchPlayer() {
      this.game.playersTurn =
        this.game.playersTurn === "white" ? "black" : "white";
    },
    tileClicked(tile) {
      if (tile.selectable) {
        this.handleTowerMoveDuringPlay(tile);
      }
    },
    handleTowerMoveDuringPlay(tile, deadEndCount = 0) {
      let color = tile.color;
      this.moveTower(this.getSelectedTower(), tile);
      this.unselectTower(this.getSelectedTower());
      this.setPropertyToTowers(this.getTowers(), "selectable", false);
      let winningTower = this.checkWin();
      if (winningTower) {
        this.handleWin(winningTower);
        return;
      }
      this.switchPlayer();
      this.selectTower(this.getTower(this.game.playersTurn, color));
      this.checkDeadEnd(deadEndCount);
    },
    handleWin(winningTower) {
      let user = this.game.users.find(
        u => u.color === winningTower.playerColor
      );
      user.score += this.pointsBySumo[winningTower.sumo];
      winningTower.sumo++;

      this.newRound("right", winningTower);
    },
    checkWin() {
      let whiteTowers = this.getPlayerTowers("white");
      let whiteTowerWinner = whiteTowers.find(
        tower => this.getTileByTower(tower).y === 7
      );
      if (whiteTowerWinner) {
        return whiteTowerWinner;
      }

      let blackTowers = this.getPlayerTowers("black");
      let blackTowerWinner = blackTowers.find(
        tower => this.getTileByTower(tower).y === 0
      );
      if (blackTowerWinner) {
        return blackTowerWinner;
      }
    },
    moveTower(tower, targetTile) {
      let copy = getTowerCopy(tower);
      let fromTile = this.getTileByTower(tower);
      fromTile.tower = null;
      targetTile.tower = copy;
    },
    unsetPossibleTiles() {
      for (var i = 0; i < this.game.tiles.length; i++) {
        this.game.tiles[i].selectable = false;
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
      let counter = 1;
      while (
        this.inBound(tile.x, y) &&
        (!this.getTileByCoord(tile.x, y).tower ||
          this.canPush(tower, this.getTileByCoord(tile.x, y).tower)) &&
        counter <= this.maxTilesBySumo[tower.sumo]
      ) {
        this.getTileByCoord(tile.x, y).selectable = true;
        y = this.nextY(y, tower.playerColor);
        counter++;
      }
    },
    canPush(tower, otherTower) {
      console.log(tower, otherTower);
      if (tower.sumo === 0) {
        return false;
      }

      // Check push by one
      if (tower.playerColor === otherTower.playerColor) {
        return false;
      }

      let tile = this.getTileByTower(tower);
      if (tower.playerColor === "white") {
        let checkY = tile.y + 2;
        return checkY > 7 && !this.getTileByCoord(tile.x, checkY).tower;
      } else if (tower.playerColor === "black") {
        let checkY = tile.y - 2;
        return checkY < 0 && !this.getTileByCoord(tile.x, checkY).tower;
      }
    },
    setPossibleTilesDiagonnally(tower, deltaX) {
      let tile = this.getTileByTower(tower);
      let x = tile.x + deltaX;
      let y = this.nextY(tile.y, tower.playerColor);
      let counter = 1;
      while (
        this.inBound(x, y) &&
        !this.getTileByCoord(x, y).tower &&
        counter <= this.maxTilesBySumo[tower.sumo]
      ) {
        this.getTileByCoord(x, y).selectable = true;
        y = this.nextY(y, tower.playerColor);
        x = x + deltaX;
        counter++;
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
    checkDeadEnd(deadEndCount) {
      let possibleMovesCount = this.getSelectableTiles().length;
      if (possibleMovesCount === 0) {
        if (deadEndCount === 1) {
          return;
        }
        let selectedTower = this.getSelectedTower();
        let currentTile = this.getTileByTower(selectedTower);
        this.handleTowerMoveDuringPlay(currentTile, 1);
      }
    },
    getSelectedTower() {
      return this.getTowers().find(t => t.selected);
    },
    getSelectableTiles() {
      return this.game.tiles.filter(t => t.selectable);
    },
    getPlayerTowers(playerColor) {
      let towers = this.getTowers();
      return towers.filter(t => t.playerColor === playerColor);
    },
    getTileByCoord(x, y) {
      return this.game.tiles.find(t => t.x === x && t.y === y);
    },
    getTileByTower(tower) {
      return this.game.tiles.find(t => t.tower === tower);
    },
    getTowers() {
      return this.game.tiles.filter(t => t.tower).map(t => t.tower);
    },
    getTower(playerColor, color) {
      let playerTowers = this.getPlayerTowers(playerColor);
      return playerTowers.find(t => t.color === color);
    }
  },
  created() {
    this.setPropertyToTowers(
      this.getPlayerTowers(this.game.playersTurn),
      "selectable",
      "true"
    );
  }
};
</script>

<style scoped lang="scss">
#gameManager {
  text-align: center;
}
.game-manager {
  display: grid;
  grid-template-columns: 1fr 5fr;
}
</style>

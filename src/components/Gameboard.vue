<template>
  <div>
    <h3>Game: {{ gameId }}</h3>
    <h5>Turn's: {{ turn === 0 ? "White" : "Black" }}</h5>
    <button class="btn btn-primary mb-3" @click="saveGame">Save</button>
    <br>
    <button
      class="btn btn-large btn-secondary"
      @click="undoMove"
      :disabled="moveCounter == 0"
    >&laquo;</button>
    <span class="mx-3">{{moveCounter}}</span>
    <button
      class="btn btn-large btn-secondary"
      @click="doMove"
      :disabled="moveCounter == moves.length"
    >&raquo;</button>
    <table v-if="tileColors.length > 0 && towers.length == 16">
      <tr v-for="y in 8" :key="'kamiRow_' + y">
        <td
          v-for="x in 8"
          :key="'tile_' + x + '_' + y"
          :class="getTileClass(x,y)"
          :style="getTileStyle(x, y)"
          @click="tileClicked(x, y)"
        >
          <div
            v-if="getTower(x,y) !== null"
            :class="getTowerClass(x,y)"
            :style="getTowerStyle(x,y)"
            @click="towerClicked(x, y)"
          >
            <span
              class="tower__symbol"
              :style="{color:getTowerColor( getTower(x,y).colorId) }"
            >{{ getSymbol( getTower(x,y).colorId)}}</span>
          </div>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import TileColors from "../assets/TileColors.json";
import Colors from "../assets/Colors.json";
import Symbols from "../assets/Symbols.json";

export default {
  data() {
    return {
      message: "",
      messageDuration: 3000,
      moves: [],
      gameId: this.$route.params.id,
      tileColors: [],
      towers: [],
      turn: 1,
      selectedTower: null,
      possibleMovesArray: [],
      moveCounter: 0
    };
  },
  methods: {
    switchTurn() {
      if (this.turn === 1) this.turn = 0;
      else if (this.turn === 0) this.turn = 1;
      else console.error(id + " is invalid.");
    },
    getTileColor(id) {
      return Colors.tiles[id];
    },
    getPlayerColor(id) {
      return Colors.players[id];
    },
    getTowerColor(id) {
      return Colors.towers[id];
    },
    getSymbol(id) {
      return Symbols[id];
    },
    getTower(x, y) {
      let filter = this.towers.filter(t => t.x === x && t.y === y);
      if (filter.length === 1) return filter[0];
      else return null;
    },
    getTowerByPlayerIdAndColor(playerId, colorId) {
      let filter = this.towers.filter(
        t => t.playerId === playerId && t.colorId === colorId
      );
      if (filter.length === 1) return filter[0];
      else return null;
    },
    isPossibleMove(x, y) {
      if (this.possibleMovesArray !== null) {
        for (let i in this.possibleMovesArray) {
          if (
            this.possibleMovesArray[i].x === x &&
            this.possibleMovesArray[i].y === y
          ) {
            return true;
          }
        }
      }

      return false;
    },
    getPossibleMoves(tower) {
      let possibles = [];
      if (tower === null) return possibles;
      let y = this.nextY(tower.y, tower.playerId);
      let xLeft = tower.x - 1;
      let xRight = tower.x + 1;

      // Vertical
      while (this.getTower(tower.x, y) === null && y >= 1 && y <= 8) {
        possibles.push({ x: tower.x, y: y });
        y = this.nextY(y, tower.playerId);
      }

      // Diagonally to the left
      y = this.nextY(tower.y, tower.playerId);
      while (
        this.getTower(xLeft, y) === null &&
        y >= 1 &&
        y <= 8 &&
        xLeft >= 1
      ) {
        possibles.push({ x: xLeft, y: y });
        y = this.nextY(y, tower.playerId);
        xLeft--;
      }

      // Diagonally to the right
      y = this.nextY(tower.y, tower.playerId);
      while (
        this.getTower(xRight, y) === null &&
        y >= 1 &&
        y <= 8 &&
        xRight <= 8
      ) {
        possibles.push({ x: xRight, y: y });
        y = this.nextY(y, tower.playerId);
        xRight++;
      }

      return possibles;
    },
    nextY(y, playerId) {
      return playerId === 0 ? y + 1 : y - 1;
    },
    getTowerClass(x, y) {
      let classes = ["tower"];
      let tower = this.getTower(x, y);
      if (tower.playerId === this.turn && this.moveCounter === 0) {
        classes.push("possible");
      }
      if (this.selectedTower !== null && this.selectedTower === tower) {
        classes.push("tower--selectedPlayer" + this.turn);
      }
      return classes;
    },
    getTowerStyle(x, y) {
      return {
        backgroundColor: this.getPlayerColor(this.getTower(x, y).playerId)
      };
    },
    getTileClass(x, y) {
      let classes = ["tile"];
      if (this.possibleMovesArray !== null && this.isPossibleMove(x, y)) {
        classes.push("possible");
      }
      return classes;
    },
    getTileStyle(x, y) {
      if (this.isPossibleMove(x, y)) {
        return {
          backgroundColor: this.tileColors[y - 1][x - 1],
          boxShadow: "0 0 5px 0 #fff inset, 0 0 0 5px #000 inset",
          cursor: "pointer"
        };
      } else if (
        this.selectedTower !== null &&
        this.selectedTower.x === x &&
        this.selectedTower.y === y
      ) {
        return {
          backgroundColor: this.tileColors[y - 1][x - 1],
          boxShadow: "0 0 5px 0 #aaa inset, 0 0 0 5px #000 inset"
        };
      } else {
        return {
          backgroundColor: this.tileColors[y - 1][x - 1]
        };
      }
    },
    tileClicked(x, y) {
      if (this.isPossibleMove(x, y)) {
        if (this.moveCounter !== this.moves.length) {
          this.moves.splice(this.moveCounter);
        }
        this.moves.push(this.getMove(this.selectedTower, { x, y }));
        this.doMove();
      }
    },
    towerClicked(x, y) {
      let tower = this.getTower(x, y);
      if (this.moveCounter === 0) {
        if (this.selectedTower === tower) {
          this.selectedTower = null;
          this.possibleMovesArray = [];
          return;
        }
        if (this.turn === tower.playerId) {
          this.selectedTower = tower;
          this.possibleMovesArray = this.getPossibleMoves(tower).slice();
          return;
        }
      }
    },
    getMove(tower, to) {
      return {
        tower: tower,
        from: {
          x: tower.x,
          y: tower.y
        },
        to: {
          x: to.x,
          y: to.y
        }
      };
    },
    doMove() {
      let move = this.moves[this.moveCounter];
      move.tower.x = move.to.x;
      move.tower.y = move.to.y;
      this.switchTurn();
      let towerToPlay = this.getTowerByPlayerIdAndColor(
        this.turn,
        TileColors[move.to.y - 1][move.to.x - 1]
      );
      this.setSelectedTower(towerToPlay);
      this.moveCounter++;
    },
    undoMove() {
      let move = this.moves[this.moveCounter - 1];
      move.tower.x = move.from.x;
      move.tower.y = move.from.y;
      this.switchTurn();
      this.setSelectedTower(move.tower);
      this.moveCounter--;
    },
    moveTower(tower, newX, newY) {
      tower.x = newX;
      tower.y = newY;
    },
    setSelectedTower(tower) {
      this.selectedTower = tower;
      this.possibleMovesArray = this.getPossibleMoves(tower).slice();
    },
    loadGame() {
      axios.get("games/" + this.gameId + ".json").then(res => {
        const data = res.data;
        const towers = [];
        for (let key in data.towers) {
          towers.push(data.towers[key]);
        }
        this.towers = towers;
        this.turn = data.turn;
        this.moveCounter = data.moveCounter;
        this.selectedTower =
          typeof data.selectedTower === "undefined"
            ? null
            : this.towers[data.selectedTower];
        this.possibleMovesArray =
          typeof data.possibleMovesArray === "undefined"
            ? []
            : data.possibleMovesArray;
        this.moves = typeof data.moves === "undefined" ? [] : data.moves;
      });
    },
    saveGame() {
      axios
        .put("games/" + this.gameId + ".json", {
          towers: this.towers,
          turn: this.turn,
          moveCounter: this.moveCounter,
          selectedTower: this.towers.indexOf(this.selectedTower),
          possibleMovesArray: this.possibleMovesArray,
          moves: this.moves
        })
        .then(res => {
          this.$emit("notify", {
            message: "✓ Game saved !",
            variant: "success"
          });
        });
    }
  },
  created() {
    this.loadGame();
    this.tileColors = TileColors.map(row =>
      row.map(id => this.getTileColor(id))
    );
  }
};
</script>

<style scoped>
table {
  margin: 15px auto;
}
.tile {
  width: 10vh;
  height: 10vh;
}
.tile.possible:hover,
.tower.possible:hover {
  cursor: pointer;
}

.tower {
  cursor: default;
  border-radius: 50%;
  line-height: 7vh;
  width: 7vh;
  margin: auto;
}
.tower__symbol {
  width: 7vh;
  height: 7vh;
  display: inline-block;
  font-size: 4vh;
  font-weight: bold;
  text-align: center;
  vertical-align: middle;
}
.tower--selectedPlayer0 {
  box-shadow: 0 0 0 3px #000, 0 0 0 6px #eee;
}
.tower--selectedPlayer1 {
  box-shadow: 0 0 0 3px #eee, 0 0 0 6px #000;
}
</style>

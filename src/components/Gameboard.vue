<template>
  <div>
    <h3>Game: {{ gameId }}</h3>
    <h5>Turn's: {{ turn === 0 ? "White" : "Black" }}</h5>
    <input type="text" v-model="userId">
    <span>{{userId}}</span>
    <button
      class="btn btn-primary mb-3"
      @click="confirmMove"
      :disabled="!isMyTurn || moveToConfirm === null"
    >{{saveButtonText}}</button>
    <br>
    <div id="gameboardContainer">
      <div id="gameboard" v-if="tileColors.length > 0">
        <div
          class="tile"
          v-for="i in 64"
          :key="'tile_' + i"
          :class="getTileClass(getXFromIndex(i), getYFromIndex(i))"
          :style="getTileStyle(getXFromIndex(i), getYFromIndex(i))"
          @click="tileClicked(getXFromIndex(i), getYFromIndex(i))"
        ></div>
      </div>
    </div>
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
  props: ["users", "roundId", "gameId"],

  data() {
    return {
      moves: [],
      moveToConfirm: null,
      tileColors: [],
      towers: [],
      turn: 1,
      selectedTowerId: null,
      userId: "User4563"
    };
  },
  computed: {
    isMyTurn() {
      return this.users.map(u => u.id)[this.turn] === this.userId;
    },
    saveButtonText() {
      if (this.isMyTurn) {
        if (this.moveToConfirm === null) {
          return "Make a move";
        } else {
          return "Confirm and save";
        }
      }
      return "Waiting for other player";
    },
    otherTurn() {
      if (this.turn === 1) return 0;
      else if (this.turn === 0) return 1;
      else console.error(id + " is invalid.");
    },
    selectedTower() {
      if (this.selectedTowerId === null) {
        return null;
      }
      return this.towers[this.selectedTowerId];
    },
    possibleMovesArray() {
      let possibles = [];
      let move = this.moveToConfirm;
      let nextY = function(y, towerId) {
        return towerId < 8 ? y + 1 : y - 1;
      };

      if (move === null) return possibles;
      let y = nextY(move.from.y, move.towerId);
      let xLeft = move.from.x - 1;
      let xRight = move.from.x + 1;

      // Vertical
      while (
        (this.getTower(move.from.x, y) === null ||
          this.getTower(move.from.x, y).id === move.towerId) &&
        y >= 1 &&
        y <= 8
      ) {
        possibles.push({ x: move.from.x, y: y });
        y = nextY(y, move.towerId);
      }

      // Diagonally to the left
      y = nextY(move.from.y, move.towerId);
      while (
        (this.getTower(xLeft, y) === null ||
          this.getTower(xLeft, y).id === move.towerId) &&
        y >= 1 &&
        y <= 8 &&
        xLeft >= 1
      ) {
        possibles.push({ x: xLeft, y: y });
        y = nextY(y, move.towerId);
        xLeft--;
      }

      // Diagonally to the right
      y = nextY(move.from.y, move.towerId);
      while (
        (this.getTower(xRight, y) === null ||
          this.getTower(xRight, y).id === move.towerId) &&
        y >= 1 &&
        y <= 8 &&
        xRight <= 8
      ) {
        possibles.push({ x: xRight, y: y });
        y = nextY(y, move.towerId);
        xRight++;
      }

      return possibles;
    }
  },
  methods: {
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
    isWin() {
      for (let i = 0; i < this.towers.length; i++) {
        let tower = this.towers[i];
        if (tower.playerId === 0 && tower.y === 8) {
          return tower;
        }
        if (tower.playerId === 1 && tower.y === 1) {
          return tower;
        }
      }
      return null;
    },
    getXFromIndex(i) {
      return ((i - 1) % 8) + 1;
    },
    getYFromIndex(i) {
      return Math.floor((i - 1) / 8) + 1;
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
      if (
        this.possibleMovesArray !== null &&
        // (this.moveCounter == this.moves.length ||
        //   this.moveCounter == this.moves.length - 1) &&
        this.isMyTurn
      ) {
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
    getTowerClass(x, y) {
      let classes = ["tower"];
      let tower = this.getTower(x, y);
      if (tower.playerId === this.turn && this.moves.length === 0) {
        classes.push("possible");
      }
      if (this.selectedTower !== null && this.selectedTower === tower) {
        classes.push("tower--selectedPlayer" + this.turn);
      }
      if (tower.isWon) {
        classes.push("tower--winner");
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
        // if (this.moveCounter !== this.moves.length) {
        //   this.moves.splice(this.moveCounter);
        // }
        this.moveToConfirm = this.getMove(this.selectedTower, { x, y });
        this.selectedTower.x = this.moveToConfirm.to.x;
        this.selectedTower.y = this.moveToConfirm.to.y;
      }
    },
    towerClicked(x, y) {
      if (this.moves.length === 0) {
        let tower = this.getTower(x, y);

        if (this.turn === tower.playerId) {
          if (this.moveToConfirm !== null) {
            this.towers[
              this.moveToConfirm.towerIndex
            ].x = this.moveToConfirm.from.x;
            this.towers[
              this.moveToConfirm.towerIndex
            ].y = this.moveToConfirm.from.y;
            this.moveToConfirm = null;
          }
          this.selectedTowerId = tower.id;
          this.moveToConfirm = this.getMove(this.selectedTower, { x, y });
          //this.possibleMovesArray = this.getPossibleMoves(tower).slice();
          return;
        }
      }
    },
    getMove(tower, to) {
      return {
        towerId: tower.id,
        from: {
          x: this.moveToConfirm === null ? tower.x : this.moveToConfirm.from.x,
          y: this.moveToConfirm === null ? tower.y : this.moveToConfirm.from.y
        },
        to: {
          x: to.x,
          y: to.y
        }
      };
    },
    confirmMove() {
      this.moves.push(this.moveToConfirm);
      let towerToPlayNext = this.getTowerByPlayerIdAndColor(
        this.otherTurn,
        TileColors[this.moveToConfirm.to.y - 1][this.moveToConfirm.to.x - 1]
      );
      this.checkWin();
      this.moveToConfirm == null;
      this.selectedTowerId = towerToPlayNext.id;
      this.turn = this.otherTurn;
      this.saveRound();
    },
    checkWin() {
      let winningTower = this.isWin();
      if (winningTower !== null) {
        winningTower.isWon = true;
        this.$emit("winRound", {
          playerId: winningTower.playerId,
          points: 1
        });
      }
    },
    undoMove() {
      let move = this.moves[this.moves.length - 1];
      let tower = this.towers[move.towerIndex];
      tower.x = move.from.x;
      tower.y = move.from.y;
      this.selectedTowerId = tower.id;
    },
    moveTower(tower, newX, newY) {
      tower.x = newX;
      tower.y = newY;
    },
    loadRound() {
      axios.get("games/" + this.gameId + "/rounds.json").then(res => {
        const data = res.data;
        const round = data[this.roundId];
        this.towers = round.towers.slice();
        this.turn = round.turn;
        this.selectedTowerId =
          typeof round.selectedTowerId === "undefined"
            ? null
            : round.selectedTowerId;
        // this.possibleMovesArray =
        //   typeof data.possibleMovesArray === "undefined"
        //     ? []
        //     : data.possibleMovesArray;
        this.moves = typeof round.moves === "undefined" ? [] : round.moves;

        this.$emit("notify", {
          message: "✓ Round loaded",
          variant: "success"
        });
      });
    },
    saveRound() {
      this.$emit("save-round", {
        towers: this.towers,
        turn: this.turn,
        selectedTowerId: this.selectedTowerId,
        moves: this.moves
      });
    }
  },
  created() {
    this.loadRound();
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

#gameboard {
  display: grid;
  grid-template-columns: repeat(8, fit-content(10vh));
  justify-content: center;
  justify-items: center;
  align-items: center;
}
.tile {
  width: 10vh;
  height: 10vh;
  background-color: #00aadd;
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

.tower--winner {
  animation: ping 0.8s ease-in-out infinite both;
}
@keyframes ping {
  0% {
    -webkit-transform: scale(0.8);
    transform: scale(0.8);
    opacity: 1;
  }
  50% {
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
    opacity: 1;
  }
  100% {
    -webkit-transform: scale(0.8);
    transform: scale(0.8);
    opacity: 1;
  }
}
</style>

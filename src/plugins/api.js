import axios from "axios";

export const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  headers: {
    'Content-Type': 'application/json; charset=UTF-8'
  }
});

export const newGame = (player1Id, player2Id, pointsToWin) => {
  return api.post("new-game", {
    player1Id,
    player2Id,
    pointsToWin
  })
}

export const getGame = (gameId) => {
  return api.get("get-game?gameId=" + gameId)
}
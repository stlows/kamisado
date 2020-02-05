import axios from "axios";

export const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  headers: {
    'Content-Type': 'application/json; charset=UTF-8'
  }
});

export const newGame = (lobbyId) => {
  return api.post("new-game", { lobbyId })
}

export const getGame = (gameId) => {
  return api.get("game?gameId=" + gameId)
}

export const getMyGames = () => {
  return api.get("my-games")
}

export const getTiles = () => {
  return api.get("tiles")
}

export const getLobby = () => {
  return api.get("lobby")
}

export const newLobby = (pointsToWin) => {
  return api.post("new-lobby", { pointsToWin })
}

export const deleteLobby = (lobbyId) => {
  return api.post("delete-lobby", { lobbyId })
}
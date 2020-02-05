import axios from "axios";

export const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  headers: {
    'Content-Type': 'application/json; charset=UTF-8',
  }
});

export const newGame = (lobbyId) => {
  return api.post("new-game.php", { lobbyId })
}

export const getGame = (gameId) => {
  return api.get("game.php?gameId=" + gameId)
}

export const getMyGames = () => {
  return api.get("my-games.php")
}

export const getTiles = () => {
  return api.get("tiles.php")
}

export const getLobby = () => {
  return api.get("lobby.php")
}

export const newLobby = (pointsToWin) => {
  return api.post("new-lobby.php", { pointsToWin })
}

export const deleteLobby = (lobbyId) => {
  return api.post("delete-lobby.php", { lobbyId })
}
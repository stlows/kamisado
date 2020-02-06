import axios from "axios";

export const api = axios.create({
  baseURL: process.env.VUE_APP_API_URL,
  headers: {
    'Content-Type': 'application/json; charset=UTF-8',
  }
});

export const newGame = (lobbyId, token) => {
  return api.post("new-game.php", { lobbyId }, {
    headers: {
      'Authorization': token
    }
  })
}

export const getGame = (gameId, token) => {
  return api.get("game.php?gameId=" + gameId, {
    headers: {
      'Authorization': token
    }
  })
}

export const getMyGames = () => {
  return api.get("my-games.php")
}

export const getTiles = () => {
  return api.get("tiles.php")
}

export const getLobby = (token) => {
  return api.get("lobby.php", {
    headers: {
      'Authorization': token
    }
  })
}

export const newLobby = (pointsToWin) => {
  return api.post("new-lobby.php", { pointsToWin })
}

export const deleteLobby = (lobbyId) => {
  return api.post("delete-lobby.php", { lobbyId })
}
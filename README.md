# Kamisado

## FRONT

Vue JS

## BACK

PHP

### API documentation

#### Authorization
Add a header:
```
Authorization: token
```
where `token` is the google authentication token.

#### Endpoints

Base `/api/`

---
##### `POST new-lobby`
Request:
```
{
	"pointsToWin": 3
}
```

Response: The newly created lobby ID
```
43
```
---
##### `GET lobby`
Request: No parameters

Response: List of all the lobby.
```
[
    {
        "player_name": "Player Name",
        "points_to_win": "3",
        "lobby_id": "48"
    }
]
```
---
##### `POST new-game`
Request:
```
{
	"lobbyId": 48
}
```

Response: The newly created game ID
```
76
```
---
##### `POST delete-lobby`
Request:
```
{
	"lobbyId": 48
}
```

Response: `DELETED` or `ERROR DELETING LOBBY`
```
DELETED
```
---
##### `GET my-games`
Request: No parameters

Response: List of all your games
```
[
    {
        "game_id": "70",
        "points_to_win": "3",
        "rival_name": "Your Rival",
        "your_score": "0",
        "rival_score": "0"
    },
    {
        "game_id": "71",
        "points_to_win": "7",
        "rival_name": "John Doe",
        "your_score": "3",
        "rival_score": "5"
    }
]
```
---
#### `GET game`
Request:
```
{
	"gameId": 48
}
```
Response: The game
```
{
  "game": {
      "game_id": "70",
      "player_1_id": "10",
      "player_2_id": "9",
      "player_1_score": "0",
      "player_2_score": "0",
      "points_to_win": "3",
      "tower_id_to_move": null,
      "is_first_move": "1",
      "turn_player_id": "10",
      "turn_color": ""
  },
  "towers": [
      {
          "tower_id": "1313",
          "game_id": "70",
          "tower_color": "orange",
          "player_color": "white",
          "sumo": "0",
          "position_x": "1",
          "position_y": "1",
          "symbol": "주",
          "player_id": "10"
      },
      ...
  ]
}
```
---
#### `move`
Request:
```
{
	"towerId": 497,
	"target":{
		"x": 3,
		"y": 2
	}
}

```
Response: The game
```
{
  "game": {
      "game_id": "70",
      "player_1_id": "10",
      "player_2_id": "9",
      "player_1_score": "0",
      "player_2_score": "0",
      "points_to_win": "3",
      "tower_id_to_move": null,
      "is_first_move": "1",
      "turn_player_id": "10",
      "turn_color": ""
  },
  "towers": [
      {
          "tower_id": "1313",
          "game_id": "70",
          "tower_color": "orange",
          "player_color": "white",
          "sumo": "0",
          "position_x": "1",
          "position_y": "1",
          "symbol": "주",
          "player_id": "10"
      },
      ...
  ]
}
```

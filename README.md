# Kamisado

## Trello
[Trello](https://trello.com/b/2Nd4en6V/kamisado)

## FRONT

Front is in Vue JS.

## BACK

Back is in PHP and a MySQL database.

## API documentation

### Authorization
Add a header:
```
Authorization: token
```
where `token` is the google authentication token.


### Endpoints

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
#### `GET game?gameId={gameId}`
Request: In the query string.

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
#### `POST move`
Request:
```
{
	"towerId": 497,
	"target":{
		"x": 1,
		"y": 2
	}
}

```
Response:

If move is valid
```
{
    "valid": true,
    "tower_id_to_move": 508
}
```
If move is not valid
```
{
    "valid": false,
    "message": "Explanation why the move is not valid"
}
```
---
#### `POST forfeit`
Request:
```
{
	"gameId": 48
}

```
Response: `FORFEITED` or `ERROR FORFEITING`

---
#### `GET tiles`
Request: No parameters

Response: List of tiles

```
[
    {
        "tile_id": "1",
        "position_x": "1",
        "position_y": "1",
        "color": "orange"
    },
    {
        "tile_id": "2",
        "position_x": "2",
        "position_y": "1",
        "color": "blue"
    },
    ...
]
```

---
#### `GET tower?towerId={towerId}`
Request: In the query string.

Response: The tower.

```
{
    "tower_id": "1025",
    "game_id": "50",
    "tower_color": "orange",
    "player_color": "white",
    "sumo": "0",
    "position_x": "1",
    "position_y": "1",
    "symbol": "주",
    "player_id": "5"
}
```

#### Errors

Response on error:
```
{
    "error": ERROR_CODE
    "message": "Explanation message"
}
```

|Error code|Message|
|---|---|
|5000|Only POST requested are allowed|
|5001|Only GET requested are allowed|
|5002|Unhandled error|
|5003|No authorization header|
|5004|Can't authenticate user|
|5005|Can't join your own game|
|5006|No game found with this ID|
|5007|This game doesn't have 16 towers|
|5008|Error moving your tower|
|5009|Error updating game|
|5010|Unexpected value in request|

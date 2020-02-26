<?php
require_once '../errors.php';

function getNewConn()
{
  $conn = new mysqli("localhost", "root", "", "kamisado");
  $conn->set_charset("utf8");
  return $conn;
}

function getLoginPlayerId($conn)
{
  $google_id = $_SESSION["google_id"];
  $query = "SELECT * FROM players WHERE google_id = '$google_id'";
  $result = $conn->query($query);
  if ($result->num_rows == 1) {
    return $result->fetch_assoc()["player_id"];
  } else if ($result->num_rows == 0) {
    $name = $_SESSION["google_name"];
    $query = "INSERT INTO players (player_name, google_id) VALUES ('$name', '$google_id')";
    $result = $conn->query($query);
    return  $conn->insert_id;
  } else {
  }
}
function newGame($lobby_id)
{
  $conn = getNewConn();

  $lobby = getLobby($lobby_id);

  $player_2_id = getLoginPlayerId($conn);
  $player_1_id = $lobby["player_id"];
  if ($lobby["player_id"] == $player_2_id) {
    global $CANT_JOIN_YOUR_OWN_GAME;
    echo json_encode($CANT_JOIN_YOUR_OWN_GAME);
    exit;
  }

  $gameQuery = "
  INSERT INTO games
  (player_1_id, player_2_id, player_1_score, player_2_score, points_to_win, is_first_move, tower_id_to_move, turn_player_id, turn_color)
  VALUES
  ($player_1_id, $player_2_id, 0, 0, " . $lobby["points_to_win"] . ", true, null, $player_1_id, 'white')";

  $conn->query($gameQuery);

  $game_id = $conn->insert_id;

  $towersQuery = "
  INSERT INTO towers
  (game_id,tower_color,player_color,position_x,position_y,sumo,symbol,player_id)
  VALUES
  ($game_id,'orange','white',1,1,0,'주',$player_1_id),
  ($game_id,'blue','white',2,1,0,'푸',$player_1_id),
  ($game_id,'indigo','white',3,1,0,'남',$player_1_id),
  ($game_id,'pink','white',4,1,0,'담',$player_1_id),
  ($game_id,'yellow','white',5,1,0,'노',$player_1_id),
  ($game_id,'red','white',6,1,0,'빨',$player_1_id),
  ($game_id,'green','white',7,1,0,'녹',$player_1_id),
  ($game_id,'brown','white',8,1,0,'갈',$player_1_id),
  ($game_id,'brown','black',1,8,0,'갈',$player_2_id),
  ($game_id,'green','black',2,8,0,'녹',$player_2_id),
  ($game_id,'red','black',3,8,0,'빨',$player_2_id),
  ($game_id,'yellow','black',4,8,0,'노',$player_2_id),
  ($game_id,'pink','black',5,8,0,'담',$player_2_id),
  ($game_id,'indigo','black',6,8,0,'남',$player_2_id),
  ($game_id,'blue','black',7,8,0,'푸',$player_2_id),
  ($game_id,'orange','black',8,8,0,'주',$player_2_id)
  ";
  $conn->query($towersQuery);
  return $game_id;
}

function getGame($game_id)
{
  $conn = getNewConn();
  $player_id = getLoginPlayerId($conn);
  $gameQuery = "SELECT * FROM games WHERE game_id = $game_id";

  $gameResult = $conn->query($gameQuery);

  if ($gameResult->num_rows > 1) {
  } else if ($gameResult->num_rows == 0) {
    global $NO_GAME_FOUND;
    echo json_encode($NO_GAME_FOUND);
    exit;
  } else {
    $game = $gameResult->fetch_assoc();
    $towersQuery = "SELECT * FROM towers WHERE game_id = $game_id";

    $towersResult = $conn->query($towersQuery);
    if ($towersResult->num_rows == 16) {
      $towers = $towersResult->fetch_all(MYSQLI_ASSOC);
      return [
        "game" => $game,
        "towers" => $towers
      ];
    } else {
      global $GAME_DOESNT_HAVE_SIXTEEN_TOWERS;
      echo json_encode($GAME_DOESNT_HAVE_SIXTEEN_TOWERS);
      exit;
    }
  }
}

function getMyGames()
{
  $conn = getNewConn();

  $player_id = getLoginPlayerId($conn);

  $query = "SELECT
  game_id,
  points_to_win,
  CASE
    WHEN p1.player_id = $player_id THEN p2.player_name
    WHEN p2.player_id = $player_id THEN p1.player_name
  END AS rival_name,
  CASE
    WHEN p1.player_id = $player_id THEN games.player_1_score
    WHEN p2.player_id = $player_id THEN games.player_2_score
  END AS your_score,
  CASE
    WHEN p1.player_id = $player_id THEN games.player_2_score
    WHEN p2.player_id = $player_id THEN games.player_1_score
  END AS rival_score
  FROM games
  LEFT JOIN players p1 ON games.player_1_id = p1.player_id
  LEFT JOIN players p2 ON games.player_2_id = p2.player_id
  WHERE $player_id IN (p1.player_id, p2.player_id)
  ";

  $result = $conn->query($query);

  return $result->fetch_all(MYSQLI_ASSOC);
}

function getTower($tower_id)
{
  $conn = getNewConn();
  $towerQuery = "SELECT * FROM towers WHERE tower_id = $tower_id";

  $towerResult = $conn->query($towerQuery);

  if ($towerResult->num_rows > 1) {
  } else if ($towerResult->num_rows == 0) {
  } else {
    return $towerResult->fetch_assoc();
  }
}

function moveTower($tower_id, $target_x, $target_y){
  $conn = getNewConn();
  $towerQuery = "UPDATE towers SET position_x = $target_x, position_y = $target_y WHERE tower_id = $tower_id";

  return $conn->query($towerQuery);
}

function getTileColor($x, $y, $conn){
  $query = "SELECT color FROM tiles WHERE position_x = $x AND position_y = $y";
  $result = $conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["color"];
  }
}

function getTowerByColorAndGame($game_id, $color, $loggedInId, $conn){
  $query = "SELECT tower_id FROM towers WHERE game_id = $game_id AND tower_color = '$color' AND player_id != $loggedInId";
  $result = $conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["tower_id"];
  }
}

function updateGame($game_id, $loggedInId, $target_x, $target_y){
  $conn = getNewConn();
  $color = getTileColor($target_x, $target_y, $conn);
  $tower_to_move = getTowerByColorAndGame($game_id, $color, $loggedInId, $conn);

  $query = "UPDATE games
  SET
  is_first_move = 0,
  turn_player_id = CASE WHEN player_1_id = $loggedInId THEN player_2_id
                        WHEN player_2_id = $loggedInId THEN player_1_id
                        END,
  tower_id_to_move = $tower_to_move,
  turn_color = CASE WHEN turn_color = 'white' THEN 'black'
                    WHEN turn_color = 'black' THEN 'white'
                    END
  WHERE game_id = $game_id";

  if($conn->query($query)){
    return $tower_to_move;
  }
  return null;
}

function getTiles()
{
  $conn = getNewConn();
  $query = "SELECT * FROM tiles";

  $result = $conn->query($query);

  if ($result->num_rows != 64) {
  } else {
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}

function newLobby($points_to_win)
{
  $conn = getNewConn();

  $player_id = getLoginPlayerId($conn);

  $query = "
  INSERT INTO lobby
  (points_to_win, player_id)
  VALUES
  ($points_to_win, $player_id)";

  $conn->query($query);

  return $conn->insert_id;
}

function getAllLobby()
{
  $conn = getNewConn();
  $player_id = getLoginPlayerId($conn);
  $query = "SELECT player_name, points_to_win, lobby_id FROM lobby LEFT JOIN players ON players.player_id = lobby.player_id";

  $result = $conn->query($query);

  return $result->fetch_all(MYSQLI_ASSOC);
}

function getLobby($lobby_id)
{
  $conn = getNewConn();
  $player_id = getLoginPlayerId($conn);
  $query = "SELECT * FROM lobby WHERE lobby_id = $lobby_id";

  $result = $conn->query($query);
  if ($result->num_rows != 1) {
  } else {
    return $result->fetch_assoc();
  }
}

function deleteLobby($lobby_id)
{
  $conn = getNewConn();
  $player_id = getLoginPlayerId($conn);
  $query = "DELETE FROM lobby WHERE lobby_id = $lobby_id";

  $conn->query($query);
}

function forfeit($game_id)
{
  $conn = getNewConn();
  $player_id = getLoginPlayerId($conn);
  $query = "DELETE FROM games WHERE game_id = $game_id";

  $conn->query($query);
}

<?php
require_once '../errors.php';


class Sql {

  private $conn;

  function __construct(){
    $this->conn = $this->getNewConn();
  }

  function getNewConn(){
    $conn = new mysqli("localhost", "root", "", "kamisado");
    $conn->set_charset("utf8");
    return $conn;
  }

function getLoginPlayerId()
{

  $google_id = $_SESSION["google_id"];
  $query = "SELECT * FROM players WHERE google_id = '$google_id'";
  $result = $this->conn->query($query);
  if ($result->num_rows == 1) {
    return $result->fetch_assoc()["player_id"];
  } else if ($result->num_rows == 0) {
    $name = $_SESSION["google_name"];
    $query = "INSERT INTO players (player_name, google_id) VALUES ('$name', '$google_id')";
    $result = $this->conn->query($query);
    return  $this->conn->insert_id;
  } else {
  }
}

function newGame($lobby_id)
{

  $lobby = $this->getLobby($lobby_id);

  $player_2_id = $this->getLoginPlayerId();
  $player_1_id = $lobby["player_id"];
  if ($lobby["player_id"] == $player_2_id) {
    global $CANT_JOIN_YOUR_OWN_GAME;
    echo json_encode($CANT_JOIN_YOUR_OWN_GAME);
    exit;
  }

  $gameQuery = "
  INSERT INTO games
  (player_1_id, player_2_id, player_1_score, player_2_score, points_to_win, is_first_move, tower_id_to_move, turn_player_id, turn_color, turn_tower_color)
  VALUES
  ($player_1_id, $player_2_id, 0, 0, " . $lobby["points_to_win"] . ", true, null, $player_1_id, 'white', null)";

  $this->conn->query($gameQuery);

  $game_id = $this->conn->insert_id;

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
  $this->conn->query($towersQuery);
  return $game_id;
}

function getCurrentPlayerId($game_id){
  $query = "SELECT turn_player_id FROM games WHERE game_id = $game_id";
  $result = $this->conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["turn_player_id"];
  }
}

function getOtherPlayerId($game_id){
  $query = "SELECT CASE WHEN player_1_id = turn_player_id THEN player_2_id
                        WHEN player_2_id = turn_player_id THEN player_1_id
                        END AS other_player_id
            FROM games WHERE game_id = $game_id";
  $result = $this->conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["other_player_id"];
  }
}

function getGame($game_id)
{

  $player_id = $this->getLoginPlayerId();

  $gameQuery = "SELECT
    game_id,
    p1.player_name player_1_name,
    p2.player_name player_2_name,
    player_1_score, player_2_score, 
    points_to_win, 
    tower_id_to_move, 
    is_first_move, 
    turn_color, 
    turn_player_id,
    turn_tower_color
    From games
    LEFT JOIN players p1 ON p1.player_id = player_1_id
    LEFT JOIN players p2 ON p2.player_id = player_2_id
    Where game_id = $game_id";

  $gameResult = $this->conn->query($gameQuery);

  if ($gameResult->num_rows > 1) {
  } else if ($gameResult->num_rows == 0) {
    global $NO_GAME_FOUND;
    echo json_encode($NO_GAME_FOUND);
    exit;
  } else {
    $game = $gameResult->fetch_assoc();
    $towersQuery = "SELECT * FROM towers WHERE game_id = $game_id";

    $towersResult = $this->conn->query($towersQuery);
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

  $player_id = $this->getLoginPlayerId();

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

  $result = $this->conn->query($query);

  return $result->fetch_all(MYSQLI_ASSOC);
}

function getTower($tower_id)
{

  $towerQuery = "SELECT * FROM towers WHERE tower_id = $tower_id";

  $towerResult = $this->conn->query($towerQuery);

  if ($towerResult->num_rows > 1) {
  } else if ($towerResult->num_rows == 0) {
  } else {
    return $towerResult->fetch_assoc();
  }
}

function moveTower($tower_id, $target_x, $target_y){

  $towerQuery = "UPDATE towers SET position_x = $target_x, position_y = $target_y WHERE tower_id = $tower_id";

  return $this->conn->query($towerQuery);
}

function getTileColor($x, $y){

  $query = "SELECT color FROM tiles WHERE position_x = $x AND position_y = $y";
  $result = $this->conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["color"];
  }
}

function getTowerByColorGameAndPlayerId($game_id, $color, $playerId){

  $query = "SELECT tower_id, tower_color FROM towers WHERE game_id = $game_id AND tower_color = '$color' AND player_id = $playerId";
  $result = $this->conn->query($query);
  if($result->num_rows == 1){
    return $result->fetch_assoc()["tower_id"];
  }
}
function updateGameAfterRoundWon($game_id, $tower){
  
  $other_player_id = $this->getOtherPlayerId($game_id);
  $player_1_or_2 = $tower["player_color"] == 'white' ? '1' : '2';
  $to_add = 1;

  $query = "UPDATE games
  SET
  is_first_move = 1,
  turn_player_id = $other_player_id,
  player_" . $player_1_or_2 . "_score = (player_" . $player_1_or_2 . "_score + $to_add),
  tower_id_to_move = NULL,
  turn_color = CASE WHEN turn_color = 'white' THEN 'black'
                    WHEN turn_color = 'black' THEN 'white'
                    END,
  turn_tower_color = NULL
  WHERE game_id = $game_id";
  $this->conn->query($query);
}

function updateGame($game_id, $target_x, $target_y){

  $color = $this->getTileColor($target_x, $target_y);
  $other_player_id = $this->getOtherPlayerId($game_id);
  $tower_to_move = $this->getTowerByColorGameAndPlayerId($game_id, $color, $other_player_id);
  $query = "UPDATE games
  SET
  is_first_move = 0,
  turn_player_id = $other_player_id,
  tower_id_to_move = $tower_to_move,
  turn_color = CASE WHEN turn_color = 'white' THEN 'black'
                    WHEN turn_color = 'black' THEN 'white'
                    END,
  turn_tower_color = '$color'
  WHERE game_id = $game_id";

  if($this->conn->query($query)){
    return $tower_to_move;
  }
  return null;
}

function getTiles()
{

  $query = "SELECT * FROM tiles";

  $result = $this->conn->query($query);

  if ($result->num_rows != 64) {
  } else {
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}

function newLobby($points_to_win)
{

  $player_id = $this->getLoginPlayerId();

  $query = "
  INSERT INTO lobby
  (points_to_win, player_id)
  VALUES
  ($points_to_win, $player_id)";

  $this->conn->query($query);

  return $this->conn->insert_id;
}

function getAllLobby()
{

  $player_id = $this->getLoginPlayerId();

  $query = "SELECT player_name, points_to_win, lobby_id FROM lobby LEFT JOIN players ON players.player_id = lobby.player_id";

  $result = $this->conn->query($query);

  return $result->fetch_all(MYSQLI_ASSOC);
}

function getLobby($lobby_id)
{
  $player_id = $this->getLoginPlayerId();

  $query = "SELECT * FROM lobby WHERE lobby_id = $lobby_id";

  $result = $this->conn->query($query);
  if ($result->num_rows != 1) {
  } else {
    return $result->fetch_assoc();
  }
}

function deleteLobby($lobby_id)
{
  $player_id = $this->getLoginPlayerId();
  $query = "DELETE FROM lobby WHERE lobby_id = $lobby_id";

  return $this->conn->query($query);
}

function forfeit($game_id)
{
  $player_id = $this->getLoginPlayerId();
  $query = "DELETE FROM games WHERE game_id = $game_id AND $player_id IN (player_1_id, player_2_id)";

  $this->conn->query($query);
}

function promoteSumo($tower_id){
  $query = "UPDATE towers SET sumo = (sumo + 1) WHERE tower_id = $tower_id";
  return $this->conn->query($query);
}

function updateTowers($newTowers){
  $query = "";
  foreach($newTowers as $tower){
    $query .= "UPDATE towers SET position_x = " . $tower["position_x"] . ", position_y = " . $tower["position_y"] . " WHERE tower_id = " . $tower["tower_id"] . ";";
  }
  return $this->conn->multi_query($query);
}

}




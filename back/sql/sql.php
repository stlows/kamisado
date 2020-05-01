<?php
require_once '../errors.php';
require_once '../constants.php';


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

  function log($query){
    //$query_log = "INSERT INTO `log` (query) VALUES ('$query')";
    //$this->conn->query($query_log);
    $timestamp = time();
    file_put_contents('C:\Git\kamisado\back\logs\logs.txt', $timestamp . " - " . $query."\r\n", FILE_APPEND);
  }

  function query($query){
    $this->log($query);
    return $this->conn->query($query);
  }

  function multi_query($query){
    $this->log($query);
    return $this->conn->multi_query($query);
  }

  function getLoginPlayerId(){
    global $PLEASE_LOGIN_FIRST;
    if(!isset($_SESSION) || !isset($_SESSION["user_id"])){
      echo(json_encode($PLEASE_LOGIN_FIRST));
      exit;
    }
    return $_SESSION["user_id"];
    
  }

  function createStubGame($gameObject){
    $game = $gameObject["game"];
    $towers = $gameObject["towers"];

    $player_1_id = $game["player_1_id"];
    $player_2_id = $game["player_2_id"];
    $player_1_score = $game["player_1_score"];
    $player_2_score = $game["player_2_score"];
    $points_to_win = $game["points_to_win"];
    $is_first_move = $game["is_first_move"];
    $turn_player_id = $game["turn_player_id"];
    $turn_color = $game["turn_color"];
    $turn_tower_color = $game["turn_tower_color"];

    $gameQuery = "INSERT INTO games
    (player_1_id, player_2_id, player_1_score, player_2_score, points_to_win, is_first_move, tower_id_to_move, turn_player_id, turn_color, turn_tower_color)
    VALUES
    ($player_1_id, $player_2_id, $player_1_score, $player_2_score, $points_to_win, $is_first_move, null, $turn_player_id, '$turn_color', '$turn_tower_color')";

    $this->query($gameQuery);

    $game_id = $this->conn->insert_id;

    foreach($towers as $tower){

      $tower_color = $tower["tower_color"];
      $player_color = $tower["player_color"];
      $position_x = $tower["position_x"];
      $position_y = $tower["position_y"];
      $sumo = $tower["sumo"];
      $player_id = $tower["player_id"];
      global $SYMBOLS;
      $symbol = $SYMBOLS[$tower_color];
      
      $tower_query = "INSERT INTO towers
      (game_id,tower_color,player_color,position_x,position_y,sumo,symbol,player_id)
      VALUES
      ($game_id,'$tower_color','$player_color',$position_x,$position_y,$sumo,'$symbol',$player_id)";
      $this->query($tower_query);
    }
    
    return $game_id;
  }

  function newGame($lobby_id){

    $lobby = $this->getLobby($lobby_id);

    $player_2_id = $this->getLoginPlayerId();
    $player_1_id = $lobby["player_id"];
    if ($lobby["player_id"] == $player_2_id) {
      global $CANT_JOIN_YOUR_OWN_GAME;
      echo json_encode($CANT_JOIN_YOUR_OWN_GAME);
      exit;
    }

    $gameQuery = "INSERT INTO games
    (player_1_id, player_2_id, player_1_score, player_2_score, points_to_win, is_first_move, tower_id_to_move, turn_player_id, turn_color, turn_tower_color)
    VALUES
    ($player_1_id, $player_2_id, 0, 0, " . $lobby["points_to_win"] . ", true, null, $player_1_id, 'white', null)";

    $this->query($gameQuery);

    $game_id = $this->conn->insert_id;

    global $ORANGE_SYMBOL, $BLUE_SYMBOL, $INDIGO_SYMBOL, $PINK_SYMBOL, $YELLOW_SYMBOL, $RED_SYMBOL, $GREEN_SYMBOL, $BROWN_SYMBOL;

    $towersQuery = "INSERT INTO towers
    (game_id,tower_color,player_color,position_x,position_y,sumo,symbol,player_id)
    VALUES
    ($game_id,'orange','white',1,1,0,'$ORANGE_SYMBOL',$player_1_id),
    ($game_id,'blue','white',2,1,0,'$BLUE_SYMBOL',$player_1_id),
    ($game_id,'indigo','white',3,1,0,'$INDIGO_SYMBOL',$player_1_id),
    ($game_id,'pink','white',4,1,0,'$PINK_SYMBOL',$player_1_id),
    ($game_id,'yellow','white',5,1,0,'$YELLOW_SYMBOL',$player_1_id),
    ($game_id,'red','white',6,1,0,'$RED_SYMBOL',$player_1_id),
    ($game_id,'green','white',7,1,0,'$GREEN_SYMBOL',$player_1_id),
    ($game_id,'brown','white',8,1,0,'$BROWN_SYMBOL',$player_1_id),
    ($game_id,'brown','black',1,8,0,'$BROWN_SYMBOL',$player_2_id),
    ($game_id,'green','black',2,8,0,'$GREEN_SYMBOL',$player_2_id),
    ($game_id,'red','black',3,8,0,'$RED_SYMBOL',$player_2_id),
    ($game_id,'yellow','black',4,8,0,'$YELLOW_SYMBOL',$player_2_id),
    ($game_id,'pink','black',5,8,0,'$PINK_SYMBOL',$player_2_id),
    ($game_id,'indigo','black',6,8,0,'$INDIGO_SYMBOL',$player_2_id),
    ($game_id,'blue','black',7,8,0,'$BLUE_SYMBOL',$player_2_id),
    ($game_id,'orange','black',8,8,0,'$ORANGE_SYMBOL',$player_2_id)
    ";
    $this->query($towersQuery);
    return $game_id;
  }

  function getCurrentPlayerId($game_id){
    $query = "SELECT turn_player_id FROM games WHERE game_id = $game_id";
    $result = $this->query($query);
    if($result->num_rows == 1){
      return $result->fetch_assoc()["turn_player_id"];
    }
  }

  function getOtherPlayerId($game_id){
    $query = "SELECT CASE WHEN player_1_id = turn_player_id THEN player_2_id
                          WHEN player_2_id = turn_player_id THEN player_1_id
                          END AS other_player_id
              FROM games WHERE game_id = $game_id";
    $result = $this->query($query);
    if($result->num_rows == 1){
      return $result->fetch_assoc()["other_player_id"];
    }
  }

  function getGame($game_id){

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

    $gameResult = $this->query($gameQuery);

    if ($gameResult->num_rows > 1) {
    } else if ($gameResult->num_rows == 0) {
      global $NO_GAME_FOUND;
      echo json_encode($NO_GAME_FOUND);
      exit;
    } else {
      $game = $gameResult->fetch_assoc();
      $towersQuery = "SELECT * FROM towers WHERE game_id = $game_id";

      $towersResult = $this->query($towersQuery);
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

  function getMyGames(){

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

    $result = $this->query($query);

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function getTower($tower_id){

    $towerQuery = "SELECT * FROM towers WHERE tower_id = $tower_id";

    $towerResult = $this->query($towerQuery);

    if ($towerResult->num_rows > 1) {
    } else if ($towerResult->num_rows == 0) {
    } else {
      return $towerResult->fetch_assoc();
    }
  }

  function moveTower($tower_id, $target_x, $target_y){

    $towerQuery = "UPDATE towers SET position_x = $target_x, position_y = $target_y WHERE tower_id = $tower_id";

    return $this->query($towerQuery);
  }

  function getTileColor($x, $y){

    $query = "SELECT color FROM tiles WHERE position_x = $x AND position_y = $y";
    $result = $this->query($query);
    if($result->num_rows == 1){
      return $result->fetch_assoc()["color"];
    }
  }

  function getTowerByColorGameAndPlayerId($game_id, $color, $playerId){

    $query = "SELECT tower_id, tower_color FROM towers WHERE game_id = $game_id AND tower_color = '$color' AND player_id = $playerId";
    $result = $this->query($query);
    if($result->num_rows == 1){
      return $result->fetch_assoc()["tower_id"];
    }
  }

  function addPoints($game_id, $tower){

    $player_1_or_2 = $tower["player_color"] == 'white' ? '1' : '2';
    global $SUMO_POINTS;
    $to_add = $SUMO_POINTS[$tower["sumo"]];

    $query = "UPDATE games
    SET
    player_" . $player_1_or_2 . "_score = (player_" . $player_1_or_2 . "_score + $to_add)
    WHERE game_id = $game_id";
    $this->query($query);
  }

  function addOnePointToPlayer($game_id, $player_color){

    $player_1_or_2 = $player_color == 'white' ? '1' : '2';
    $to_add = 1;

    $query = "UPDATE games
    SET
    player_" . $player_1_or_2 . "_score = (player_" . $player_1_or_2 . "_score + $to_add)
    WHERE game_id = $game_id";
    $this->query($query);
  }

  function checkIfGameIsWon($game_id){
    $query = "SELECT
    CASE WHEN player_1_score >= points_to_win OR player_2_score >= points_to_win THEN 1
    ELSE 0
    END AS is_game_won
    FROM games
    WHERE game_id = $game_id";
    $result = $this->query($query);
    return $result->fetch_assoc()["is_game_won"];
  }

  function setFirstMove($game_id, $value){
    $query = "UPDATE games
    SET
    is_first_move = $value
    WHERE game_id = $game_id";
    $this->query($query);
  }

  function switchTurn($game_id){
    $query = "UPDATE games
    SET
    turn_player_id = CASE WHEN player_1_id = turn_player_id THEN player_2_id
                          WHEN player_2_id = turn_player_id THEN player_1_id
                          END,
    turn_color = CASE WHEN turn_color = 'white' THEN 'black'
                      WHEN turn_color = 'black' THEN 'white'
                      END
    WHERE game_id = $game_id";
    $this->query($query);
  }

  function promoteSumo($tower_id){
    $query = "UPDATE towers SET sumo = (sumo + 1) WHERE tower_id = $tower_id";
    return $this->query($query);
  }

  function setTowerIdToMove($game_id, $tower_id){
    if($tower_id == null){
      $query = "UPDATE games SET tower_id_to_move = NULL WHERE game_id = $game_id";
    }else{
      $query = "UPDATE games SET tower_id_to_move = $tower_id WHERE game_id = $game_id";
    }
    $this->query($query);
  }

  function setTurnTowerColor($game_id, $tower_color){
    if($tower_color == null){
      $query = "UPDATE games SET turn_tower_color = NULL WHERE game_id = $game_id";
    }else{
      $query = "UPDATE games SET turn_tower_color = '$tower_color' WHERE game_id = $game_id";
    }
    $this->query($query);
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

    if($this->query($query)){
      return $tower_to_move;
    }
    return null;
  }

  function getTiles(){

    $query = "SELECT * FROM tiles";

    $result = $this->query($query);

    if ($result->num_rows != 64) {
    } else {
      return $result->fetch_all(MYSQLI_ASSOC);
    }
  }

  function newLobby($points_to_win){

    $player_id = $this->getLoginPlayerId();

    $query = "
    INSERT INTO lobby
    (points_to_win, player_id)
    VALUES
    ($points_to_win, $player_id)";

    $this->query($query);

    return $this->conn->insert_id;
  }

  function getAllLobby(){

    $player_id = $this->getLoginPlayerId();

    $query = "SELECT player_name, points_to_win, lobby_id FROM lobby LEFT JOIN players ON players.player_id = lobby.player_id";

    $result = $this->query($query);

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function getLobby($lobby_id){
    $player_id = $this->getLoginPlayerId();

    $query = "SELECT * FROM lobby WHERE lobby_id = $lobby_id";

    $result = $this->query($query);
    if ($result->num_rows != 1) {
    } else {
      return $result->fetch_assoc();
    }
  }

  function deleteLobby($lobby_id){
    $player_id = $this->getLoginPlayerId();
    $query = "DELETE FROM lobby WHERE lobby_id = $lobby_id";

    return $this->query($query);
  }

  function forfeit($game_id){
    $player_id = $this->getLoginPlayerId();
    $query = "DELETE FROM games WHERE game_id = $game_id AND $player_id IN (player_1_id, player_2_id)";

    $this->query($query);
  }

  function updateTowers($newTowers){
    $query = "";
    foreach($newTowers as $tower){
      $query .= "UPDATE towers SET position_x = " . $tower["position_x"] . ", position_y = " . $tower["position_y"] . " WHERE tower_id = " . $tower["tower_id"] . ";";
    }
    return $this->multi_query($query);
  }

  function register($credentials){
    $email = $this->conn->real_escape_string($credentials["email"]);
    $username =$this->conn->real_escape_string($credentials["username"]);
    $password = $this->conn->real_escape_string($credentials["password"]);

    // Check if user exists
    $checkUserByEmailQuery = "SELECT * FROM players WHERE email = '$email'";
    $checkUserByUsernameQuery = "SELECT * FROM players WHERE username = '$username'";

    $checkUserByEmailResult = $this->query($checkUserByEmailQuery);
    if($checkUserByEmailResult->num_rows > 0){
      global $EMAIL_ALREADY_USED;
      echo(json_encode($EMAIL_ALREADY_USED));
      exit;
    }

    $checkUserByUsernameResult = $this->query($checkUserByUsernameQuery);
    if($checkUserByUsernameResult->num_rows > 0){
      global $USERNAME_TAKEN;
      echo(json_encode($USERNAME_TAKEN));
      exit;
    }

    // Create the user
    $salt = bin2hex(random_bytes(5));
    $password_hash = hash("sha256", $salt . $password);
    $createUserQuery = "INSERT INTO players (username, email, password_hash, salt) VALUES ('$username', '$email', '$password_hash', '$salt')";
    $createUserResult = $this->query($createUserQuery);

    return $username;

  }

  function generate_verified_code($username){
    $code = rand(115000, 950000);
    $now = time();
    $delay = 86400;
    $expiration = $now + $delay;
    $updateUserQuery = "UPDATE players SET code = '$code', code_expiration = $expiration  WHERE username = '$username'";
    $updateUserResult = $this->query($updateUserQuery);
    return $code;
  }

  function verify_user($credentials){
    $code = $credentials["code"];
    $username = $credentials["username"];
    $codeInDatabaseQuery = "SELECT code, code_expiration FROM players WHERE username = '$username'";
    $result = $this->query($codeInDatabaseQuery);
    if($result->num_rows == 1){

      $assoc = $result->fetch_assoc();
      $code_expiration = $assoc["code_expiration"];
      if(time() > $code_expiration){
        global $CODE_EXPIRED;
        echo(json_encode($CODE_EXPIRED));
        exit;
      }

      $codeInDatabase = $assoc["code"];
      if($code == $codeInDatabase){
        $updateUserQuery = "UPDATE players SET verified_email = 1, code = '', code_expiration = '' WHERE username = '$username'";
        $updateUserResult = $this->query($updateUserQuery);
        echo("VERIFIED");
        exit;
      }else{
        global $WRONG_CODE;
        echo(json_encode($WRONG_CODE));
        exit;
      }
    }
  }

    function login($credentials){
      global $WRONG_CREDENTIALS;

      $username = $this->conn->real_escape_string($credentials["email"]);
      $password = $this->conn->real_escape_string($credentials["password"]);

      $userInDb = "SELECT * FROM players WHERE username = '$username' || email = '$username'";

      $result = $this->query($userInDb);

      if($result->num_rows == 1){
  
        $assoc = $result->fetch_assoc();
        $is_verified = $assoc["verified_email"];
        if(!$is_verified){
          global $EMAIL_NOT_VERIFIED;
          echo(json_encode($EMAIL_NOT_VERIFIED));
          exit;
        }

        $salt = $assoc["salt"];
        $passwordEntered = hash("sha256", $salt . $password);

        $passwordInDb = $assoc["password_hash"];

        if($passwordEntered == $passwordInDb){
          $_SESSION["user_id"] = $assoc["player_id"];
          return true;
        }
      }
      echo(json_encode($WRONG_CREDENTIALS));
      exit;
    }
}




<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../validations.php");
include_once("../errors.php");
include_once("../board.php");
include_once("../constants.php");

$move = json_decode(file_get_contents('php://input'), true);

$towerId = $move["towerId"];
$targetX = $move["target"]["x"];
$targetY = $move["target"]["y"];

checkId($towerId);
checkId($targetX);
checkId($targetY);

$sql = new Sql();

$tower = $sql->getTower($towerId);

$gameId = $tower["game_id"];
$gameObject = $sql->getGame($gameId);
$game = $gameObject["game"];
$towers = $gameObject["towers"];
$board = new Board($towers);

$loggedInId = $sql->getLoginPlayerId();

// Is it my turn
if ($game["turn_player_id"] != $loggedInId ) {
  echo (json_encode($NOT_YOUR_TURN));
  exit;
}

// Is it my tower
if ($tower["player_id"] != $loggedInId ) {
  echo (json_encode($NOT_YOUR_TOWER));
  exit;
}

// Is it this tower I am supposed to move
if (!$game["is_first_move"] && $game["tower_id_to_move"] != $towerId) {
  echo (json_encode($CANT_MOVE_THAT_TOWER));
  exit;
};

// Is it in bound
if ($targetX < 1 || $targetX > 8 || $targetY < 1 || $targetY > 8) {
  echo (json_encode($OUT_OF_BOUND));
  exit;
};

// Is the tower color white or black
if($tower["player_color"] != "white" && $tower["player_color"] != "black"){
  echo (json_encode($TOWER_COLOR_UNKNOWN));
  exit;
}

// Is it going forward
if(($tower["player_color"] == "white" && $targetY <= $tower["position_y"]) || ($tower["player_color"] == "black" && $targetY >= $tower["position_y"])){
  echo (json_encode($MUST_GO_FORWARD));
  exit;
}

// If it's a different X, is it in the same diagonal
if($targetX != $tower["position_x"] && (abs($targetX - $tower["position_x"]) != abs($targetY - $tower["position_y"]))){
  echo (json_encode($MUST_GO_DIAGONNALLY_OR_STRAIGHT_AHEAD));
  exit;
}

// Respecte le maximum de movement du sumo
if(abs($targetY - $tower["position_y"]) > $SUMO_MOVEMENTS[$tower["sumo"]]){
  echo (json_encode($SUMO_MAX_MOVES[$tower["sumo"]]));
  exit;
}

// Gérer les pushs
if($tower["player_color"] == "white"){
  if($tower["sumo"] == 1 && $tower["position_x"] == $targetX && $tower["position_y"] + 1 == $targetY){
  }
}
else{

}

// Check les overlaps
if($tower["player_color"] == "white"){
  if($tower["position_x"] == $targetX){
    for($y = $tower["position_y"] + 1; $y <= $targetY; $y++){
      // Is there a tower already there
      if(tileOccupied($targetX, $y)){
        echo (json_encode($CANT_PASS_THROUGH));
          exit;
      }
    }
  }else{
    for($delta = 1; $delta <= $targetY - $tower["position_y"]; $delta++){
      $direction = $targetX - $tower["position_x"] > 0 ? $delta : -$delta;
      if(tileOccupied($tower["position_x"] + $direction, $tower["position_y"] + $delta)){
        echo (json_encode($CANT_PASS_THROUGH));
        exit;
      }
    }
  }
}
else{
  if($tower["position_x"] == $targetX){
    for($y = $tower["position_y"] - 1; $y >= $targetY; $y--){
      // Is there is a tower already there
      if(tileOccupied($targetX, $y)){
        echo (json_encode($CANT_PASS_THROUGH));
        exit;
      }
    }
  }else{
    for($delta = 1; $delta <= $tower["position_y"] - $targetY; $delta++){
      $direction = $targetX - $tower["position_x"] > 0 ? $delta : -$delta;
      if(tileOccupied($tower["position_x"] + $direction, $tower["position_y"] - $delta)){
        echo (json_encode($CANT_PASS_THROUGH));
        exit;
      }
    }
  }
}

try {
  $moved_tower_successful = $sql->moveTower($towerId, $targetX, $targetY);
  $board->move($tower["position_x"], $tower["position_y"], $targetX, $targetY);
  
  if($moved_tower_successful){
    
    check_win();
    $tower_id_to_move = swap_turn($tower_id);
    $towerBlocked = check_block($tower_id_to_move);

    if($towerBlocked){

      $tower_id_to_move = swap_turn($tower_id_to_move)
      $towerBlocked = check_block($tower_id_to_move);
      
      if($towerBlocked){
        impasse();
      }

      echo (json_encode([
        "blocked" => true,
        "valid" => true,
        "tower_id_to_move" => $tower_id_to_move
      ]));
      exit;
    }
    else{
      echo (json_encode([
        "valid" => true,
        "tower_id_to_move" => $tower_id_to_move
      ]));
      exit;
    }
      
  }else{
    echo (json_encode($ERROR_MOVING_TOWER));
    exit;
  };

}catch(Exception $ex){
  echo (json_encode($UNHANDLED));
  exit;
}

function impasse(){
  reset_round("left");
  echo(json_encode([
    "impasse" => true
  ]));
  exit;
}

function replace_towers($dir){

  if($tower["player_color"] == "black"){
    $board->replaceBlacks($dir);
    $board->replaceWhites($dir);
  }else if($tower["player_color"] == "white"){
    $board->replaceWhites($dir);
    $board->replaceBlacks($dir);
  }
}

function reset_round($dir){
  global $sql, $gameId, $board;

  replace_towers($dir);

  $sql->setFirstMove($gameId, 1);
  $sql->switchTurn($gameId);
  $sql->setTowerIdToMove($gameId, null);
  $sql->setTurnTowerColor($gameId, null);
  $sql->updateTowers($board->towers());
}

function round_won(){
  global $sql, $tower, $board, $gameId;

  // Ajout des points
  $sql->addPoints($gameId, $tower);
  // Check game won
  $game_won = $sql->checkIfGameIsWon($gameId);
  if($game_won){
    game_won();
  }

  $sql->promoteSumo($towerId);
  reset_round("left");
  echo(json_encode([
    "valid" => true,
    "round_won_by" => $tower["player_color"]
  ]));
  exit;

}

function game_won(){
  global $tower;
  echo(json_encode([
    "valid" => true,
    "game_won_by" => $tower["player_color"]
  ]));
  exit;
}

function check_win(){
  global $targetY;

  if($targetY == 1 || $targetY == 8){
    round_won();
  }
}

function swap_turn($last_moved_tower_id){
  global $sql, $gameId;

  $tower = $sql->getTower($last_moved_tower_id);
  $tile_color = $sql->getTileColor($tower["position_x"], $tower["position_y"]);
  $other_player_id = $sql->getOtherPlayerId($gameId);
  $tower_id_to_move = $sql->getTowerByColorGameAndPlayerId($gameId, $tile_color, $other_player_id);
  
  $sql->setFirstMove($gameId, 0);
  $sql->switchTurn($gameId);
  $sql->setTowerIdToMove($gameId, $tower_id_to_move);
  $sql->setTurnTowerColor($gameId, $tile_color);
  return $tower_id_to_move;
}

function check_block($tower_id){
  global $sql, $gameId;

  $gameObject = $sql->getGame($gameId);
  $towerToMove = $sql->getTower($tower_id);
  return isTowerBlocked($towerToMove, $gameObject);
}

function isTowerBlocked($tower, $game){
  if($tower["player_color"] == "white"){
    if($tower["position_x"] == 1){
      $aboveTiles = [
        ["x" => 1, "y" => $tower["position_y"] + 1],
        ["x" => 2, "y" => $tower["position_y"] + 1]
      ];
    }else if($tower["position_x"] == 8){
      $aboveTiles = [
        ["x" => 8, "y" => $tower["position_y"] + 1],
        ["x" => 7, "y" => $tower["position_y"] + 1]
      ];
    }else{
      $aboveTiles = [
        ["x" => $tower["position_x"] - 1, "y" => $tower["position_y"] + 1],
        ["x" => $tower["position_x"], "y" => $tower["position_y"] + 1],
        ["x" => $tower["position_x"] + 1, "y" => $tower["position_y"] + 1],
      ];
    }
  }else if($tower["player_color"] == "black"){
    if($tower["position_x"] == 1){
      $aboveTiles = [
        ["x" => 1, "y" => $tower["position_y"] - 1],
        ["x" => 2, "y" => $tower["position_y"] - 1]
      ];
    }else if($tower["position_x"] == 8){
      $aboveTiles = [
        ["x" => 8, "y" => $tower["position_y"] - 1],
        ["x" => 7, "y" => $tower["position_y"] - 1]
      ];
    }else{
      $aboveTiles = [
        ["x" => $tower["position_x"] - 1, "y" => $tower["position_y"] - 1],
        ["x" => $tower["position_x"], "y" => $tower["position_y"] - 1],
        ["x" => $tower["position_x"] + 1, "y" => $tower["position_y"] - 1],
      ];
    }
  }else{

  }
  foreach($aboveTiles as $aboveTile){
    if(!tileOccupied($aboveTile["x"], $aboveTile["y"])){
      return false;
    }
  }
  return true;
}

function tileOccupied($x, $y){
  if($board[$x][$y] != []){
    return $board[$x][$y];
  }
  return false;
}

function resetTowers($towers, $winner, $dir){
  $board = new Board($towers);

  if($winner == "black"){
    $board->replaceBlacks($dir);
    $board->replaceWhites($dir);
  }else if($winner == "white"){
    $board->replaceWhites($dir);
    $board->replaceBlacks($dir);
  }

  return $board->towers();
}
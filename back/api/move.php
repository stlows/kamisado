<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../prettify.php");
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

// Check les overlaps
if($tower["player_color"] == "white"){
  if($tower["position_x"] == $targetX){
    for($y = $tower["position_y"] + 1; $y <= $targetY; $y++){
      // Is there a tower already there
      foreach($towers as $t){
        if ($t["position_x"] == $targetX && $t["position_y"] == $y) {
          // TODO Gérer les push de sumo ici ?
          echo (json_encode($CANT_PASS_THROUGH));
          exit;
        }
      }
    }
  }else{
    for($delta = 1; $delta <= $targetY - $tower["position_y"]; $delta++){
      $direction = $targetX - $tower["position_x"] > 0 ? $delta : -$delta;
      foreach($towers as $t){
        if ($t["position_x"] == $tower["position_x"] + $direction && $t["position_y"] == $tower["position_y"] + $delta) {
          echo (json_encode($CANT_PASS_THROUGH));
          exit;
        }
      }
    }
  }
}
else{
  if($tower["position_x"] == $targetX){
    for($y = $tower["position_y"] - 1; $y >= $targetY; $y--){
      // Is there is a tower already there
      foreach($towers as $t){
        if ($t["position_x"] == $targetX && $t["position_y"] == $y) {
          // TODO Gérer les push de sumo ici ?
          echo (json_encode($CANT_PASS_THROUGH));
          exit;
        }
      }
    }
  }else{
    for($delta = 1; $delta <= $tower["position_y"] - $targetY; $delta++){
      $direction = $targetX - $tower["position_x"] > 0 ? $delta : -$delta;
      foreach($towers as $t){
        if ($t["position_x"] == $tower["position_x"] + $direction && $t["position_y"] == $tower["position_y"] - $delta) {
          echo (json_encode($CANT_PASS_THROUGH));
          exit;
        }
      }
    }
  }
}

try {
  $moved_tower_successful = $sql->moveTower($towerId, $targetX, $targetY);
  if($moved_tower_successful){
    
    // Check win
    if($targetY == 1 || $targetY == 8){
      // Ajout des points
      $sql->addPoints($gameId, $tower);
      // Check game won
      $game_won = $sql->checkIfGameIsWon($gameId);
      if($game_won){
        echo(json_encode([
          "valid" => true,
          "game_won_by" => $tower["player_color"]
        ]));
        exit;
      }else{
        $sql->promoteSumo($towerId);
        $dir = "left";
        $newTowers = resetTowers($towers, $tower["player_color"], $dir);
        $sql->setFirstMove($gameId, 1);
        $sql->switchTurn($gameId);
        $sql->setTowerIdToMove($gameId, null);
        $sql->setTurnTowerColor($gameId, null);
        $sql->updateTowers($newTowers);
        echo(json_encode([
          "valid" => true,
          "round_won_by" => $tower["player_color"]
        ]));
        exit;
        
      }

    }
    else // Not win
    { 
      $tile_color = $sql->getTileColor($targetX, $targetY);
      $other_player_id = $sql->getOtherPlayerId($gameId);
      $tower_id_to_move = $sql->getTowerByColorGameAndPlayerId($gameId, $tile_color, $other_player_id);
      
      $sql->setFirstMove($gameId, 0);
      $sql->switchTurn($gameId);
      $sql->setTowerIdToMove($gameId, $tower_id_to_move);
      $sql->setTurnTowerColor($gameId, $tile_color);

      // Check block
      $gameObject = $sql->getGame($gameId);
      $towerToMove = $sql->getTower($tower_id_to_move);
      $towerBlocked = isTowerBlocked($towerToMove, $gameObject);
      if($towerBlocked){

        $tile_color = $sql->getTileColor($towerToMove["position_x"], $towerToMove["position_y"]);
        $other_player_id = $sql->getOtherPlayerId($gameId);
        $tower_id_to_move = $sql->getTowerByColorGameAndPlayerId($gameId, $tile_color, $other_player_id);
      
        $sql->switchTurn($gameId);
        $sql->setTowerIdToMove($gameId, $tower_id_to_move);
        $sql->setTurnTowerColor($gameId, $tile_color);

        echo (json_encode([
          "blocked" => true,
          "valid" => true,
          "tower_id_to_move" => $tower_id_to_move
        ]));
        exit;
      }
      else{ // Not blocked
        echo (json_encode([
          "valid" => true,
          "tower_id_to_move" => $tower_id_to_move
        ]));
        exit;
      }
      

    }
  }else{
    echo (json_encode($ERROR_MOVING_TOWER));
    exit;
  };

}catch(Exception $ex){
  echo (json_encode($UNHANDLED));
  exit;
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
    if(!tileOccupied($game["towers"], $aboveTile["x"], $aboveTile["y"])){
      return false;
    }
  }
  return true;
}

function tileOccupied($towers, $x, $y){
  foreach($towers as $tower){
    if($tower["position_x"] == $x && $tower["position_y"] == $y){
      return $tower;
    }
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
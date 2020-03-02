<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../prettify.php");
include_once("../validations.php");
include_once("../errors.php");

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

// Check les overlaps
if($tower["player_color"] == "white"){
  if($tower["position_x"] == $targetX){
    for($y = $tower["position_y"] + 1; $y <= $targetY; $y++){
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
  if($sql->moveTower($towerId, $targetX, $targetY)){
    // Check win
    if($targetY == 1 || $targetY == 8){
      // Check game won
      $game_won = false; // isGameWon(...);
      if($game_won){
        //gameWon(...);
        echo(json_encode([
          "valid" => true,
          "game_won_by" => $tower["player_color"]
        ]));
      }else{
        $sql->resetGameAfterRoundWon($game, $tower);
        echo(json_encode([
          "valid" => true,
          "round_won_by" => $tower["player_color"]
        ]));
      }

    }

    $tower_id_to_move = updateGame($gameId, $targetX, $targetY);

    if($tower_id_to_move != null){
      // Check block
      $game = $sql->getGame($gameId);
      $towerToMove = $sql->getTower($tower_id_to_move);
      $towerBlocked = isTowerBlocked($tower_id_to_move);
      if($towerBlocked){
        $tower_id_to_move = $sql->updateGame($gameId, $towerToMove["position_x"], $tower_to_move["position_y"]);
        echo (json_encode([
          "blocked" => true,
          "valid" => true,
          "tower_id_to_move" => $tower_id_to_move
        ]));
        exit;
      }
      echo (json_encode([
        "valid" => true,
        "tower_id_to_move" => $tower_id_to_move
      ]));
      exit;
    }else{
      echo (json_encode($ERROR_UPDATING_GAME));
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

function isTowerBlocked($tower, $game){
  if($tower["tower_color"] == "white"){
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
  }else if($tower["tower_color"] == "black"){
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


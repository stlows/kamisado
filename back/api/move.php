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
  if(moveTower($towerId, $targetX, $targetY)){
    // Check win
    if($targetY == 1 || $targetY == 8){
      resetGameAfterRoundWon($game, $tower);
      echo(json_encode([
        "valid" => true,
        "round_won_by" => $tower["player_color"]
      ]));
    }
    $tower_id_to_move = updateGame($gameId, $loggedInId, $targetX, $targetY);
    if($tower_id_to_move != null){
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



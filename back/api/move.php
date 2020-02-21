<?php

include_once("../check-post.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../prettify.php");
include_once("../validations.php");

$move = json_decode(file_get_contents('php://input'), true);

$towerId = $move["towerId"];
$targetX = $move["target"]["x"];
$targetY = $move["target"]["y"];

$tower = getTower($towerId);

$gameId = $tower["game_id"];
$gameObject = getGame($gameId);
$game = $gameObject["game"];
$towers = $gameObject["towers"];

$conn = getNewConn();
$loggedInId = getLoginPlayerId($conn);

// Is it my turn
if ($game["turn"] != $loggedInId ) {
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

// Is there is a tower already there
foreach($towers as $t){
  if ($t["position_x"] == $targetX && $t["position_y"] == $targetY) {
    // TODO Gérer les push de sumo ici ?
    echo (json_encode($TILE_OCCUPIED));
    exit;
  };
}

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
if($targetX != $tower["position_x"] && ($targetX - $tower["position_x"] != $targetY - $tower["position_y"])){
  echo (json_encode($MUST_GO_DIAGONNALLY_OR_STRAIGHT_AHEAD));
  exit;
}

echo (json_encode($VALID));

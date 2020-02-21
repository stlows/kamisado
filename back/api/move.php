<?php

include_once("../check-post.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../prettify.php");

$move = json_decode(file_get_contents('php://input'), true);

$towerId = $move["tower"];
$targetX = $move["target"]["x"];
$targetY = $move["target"]["y"];

$gameObject = getGame($move["gameId"]);
$game = $gameObject["game"];
$towers = $gameObject["towers"];

$tower = getTower($towerId);

$conn = getNewConn();
$loggedInId = getLoginPlayerId($conn);

// Is it my turn
if ($game["turn"] != $loggedInId ) {
  echo (json_encode([
    "valid" => false,
    "message" => "It's not your turn."
  ]));
  exit;
}

// Is it my color
if ($tower["player_id"] != $loggedInId ) {
  echo (json_encode([
    "valid" => false,
    "message" => "That is not your tower sir."
  ]));
  exit;
}

// Is it this tower I am supposed to move
if (!$game["is_first_move"] && $game["tower_id_to_move"] != $towerId) {
  echo (json_encode([
    "valid" => false,
    "message" => "Can't move that tower right now."
  ]));
  exit;
};


if ($targetX < 1 || $targetX > 8 || $targetY < 1 || $targetY > 8) {
  echo (json_encode([
    "valid" => false,
    "message" => "Stay in bound buddy."
  ]));
  exit;
};

// Is there is a tower already there
foreach($towers as $t){
  if ($t["position_x"] == $targetX && $t["position_y"] == $targetY) {
    // TODO Gérer les push ici ?
    echo (json_encode([
      "valid" => false,
      "message" => "There's already a tower there buddy."
    ]));
    exit;
  };
}

if($tower["player_color"] == "white"){
  // Is it going forward
  if($targetY <= $tower["position_y"]){
    echo (json_encode([
      "valid" => false,
      "message" => "You must go forward."
    ]));
    exit;
  }
  // Different X, must be diagonnally
  if($targetX != $tower["position_x"]){
    $deltaX = $targetX - $tower["position_x"];
    $deltaY = $targetY - $tower["position_y"];
    if($deltaX != $deltaY){
      echo (json_encode([
        "valid" => false,
        "message" => "You must go forward or diagonnally."
      ]));
      exit;
  }
  }
}
else if($tower["player_color"] == "black"){
  // Is it going forward
  if($targetY >= $tower["position_y"]){
    echo (json_encode([
      "valid" => false,
      "message" => "You must go forward."
    ]));
    exit;
  }
   // Different X, must be diagonnally
   if($targetX != $tower["position_x"]){
    $deltaX = $tower["position_x"] - $targetX;
    $deltaY = $tower["position_y"] - $targetY ;
    if($deltaX != $deltaY){
      echo (json_encode([
        "valid" => false,
        "message" => "You must go forward or diagonnally."
      ]));
      exit;
  }
  }
}else{
  echo (json_encode([
    "valid" => false,
    "message" => "Tower color unknown."
  ]));
  exit;
}







// setPossibleTilesVertically(tower) {
//   let tile = this.getTileByTower(tower);
//   let y = this.nextY(tile.y, tower.playerColor);
//   let counter = 1;
//   while (
//     this.inBound(tile.x, y) &&
//     (!this.getTileByCoord(tile.x, y).tower || this.canPush(tower, this.getTileByCoord(tile.x, y).tower) ) &&
//     counter <= this.maxTilesBySumo[tower.sumo]
//   ) {
//     this.getTileByCoord(tile.x, y).selectable = true;
//     y = this.nextY(y, tower.playerColor);
//     counter++;
//   }
// }
// setPossibleTilesDiagonnally(tower, deltaX) {
//   let tile = this.getTileByTower(tower);
//   let x = tile.x + deltaX;
//   let y = this.nextY(tile.y, tower.playerColor);
//   let counter = 1;
//   while (
//     this.inBound(x, y) &&
//     !this.getTileByCoord(x, y).tower &&
//     counter <= this.maxTilesBySumo[tower.sumo]
//   ) {
//     this.getTileByCoord(x, y).selectable = true;
//     y = this.nextY(y, tower.playerColor);
//     x = x + deltaX;
//     counter++;
//   }
// }
echo (json_encode([
  "valid" => true,
  "message" => "Move is valid."
]));

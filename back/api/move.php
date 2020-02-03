<?php

include_once("../check-post.php");
include_once("../sql.php");
include_once("../prettify.php");

$move = json_decode(file_get_contents('php://input'), true);

$towerId = $move["tower"];
$targetX = $move["target"]["x"];
$targetX = $move["target"]["y"];

$gameObject = getGame($move["gameId"]);
$game = $gameObject["game"];
$towers = $gameObject["towers"];

$tower = getTower($towerId);

// Is it my turn
if ($game["turn"] != $tower["player_color"]) {
  echo (json_encode([
    "valid" => false,
    "message" => "It's not your turn."
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





// function inBound($x, $y) {
//   return $x >= 0 && $x <= 7 && $y >= 0 && $y <= 7;
// }
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
  "game" => $gameObject
]));

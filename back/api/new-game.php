<?php

include_once("../check-post.php");
include_once("../sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$game_id = newGame($settings["player1Id"], $settings["player2Id"], $settings["pointsToWin"]);

echo $game_id;

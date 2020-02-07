<?php

include_once("../check-post.php");
include_once("../check-google-token.php");
include_once("../sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$game_id = newGame($settings["lobbyId"]);

echo $game_id;

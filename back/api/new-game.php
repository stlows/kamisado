<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$lobbyId = $settings["lobbyId"];
checkId($lobbyId);

$sql = new Sql();
$game_id = $sql->newGame($lobbyId);

echo $game_id;

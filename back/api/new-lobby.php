<?php

include_once("../check-post.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$sql = new Sql();
$lobby_id = $sql->newLobby($settings["pointsToWin"]);

echo $lobby_id;

<?php

include_once("../check-post.php");
include_once("../sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$lobby_id = newLobby($settings["pointsToWin"]);

echo $lobby_id;

<?php

include_once("../check-post.php");
include_once("../sql.php");

$move = json_decode(file_get_contents('php://input'), true);

$game = getGame($move["gameId"]);

header("Content-Type: application/json");
echo (json_encode($game));

<?php

include_once("../check-get.php");
include_once("../sql.php");

$games = getMyGames();

echo json_encode($games);

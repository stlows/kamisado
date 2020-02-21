<?php

include_once("../check-get.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$games = getMyGames();

echo json_encode($games);

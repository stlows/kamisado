<?php

include_once("../check-get.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

//$settings = json_decode(file_get_contents('php://input'), true);

//$lobbyId = $settings["lobbyId"];

$gameId = isset($_GET["gameId"]) ? $_GET["gameId"] : "";
//checkId($gameId);

$sql = new Sql();
$game = $sql->getGame($gameId);

echo (json_encode($game));

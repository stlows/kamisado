<?php

include_once("../check-get.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : "";

checkId($gameId);

$sql = new Sql();
$game = $sql->getGame($gameId);

echo (json_encode($game));

<?php

include_once("../check-get.php");
include_once("../check-id.php");
include_once("../authorization-header.php");
include_once("../sql/sql.php");

$gameId = isset($_GET["gameId"]) ? (int)$_GET["gameId"] : "";

checkId($gameId);

$sql = new Sql();
$game = $sql->getGame($gameId);

echo (json_encode($game));

<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../authorization-header.php");
include_once("../sql/sql.php");

$game = json_decode(file_get_contents('php://input'), true);

$sql = new Sql();
$game_id = $sql->createStubGame($game);

echo $game_id;

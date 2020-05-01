<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../authorization-header.php");
include_once("../sql/sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$lobbyId = $settings["lobbyId"];
checkId($lobbyId);

$credentials = getCredentialsFromHeader();
$sql = new Sql();

if($sql->login($credentials)){
  $game_id = $sql->newGame($lobbyId);
  echo(json_encode($game_id));
}


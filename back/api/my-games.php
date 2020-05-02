<?php

include_once("../check-get.php");
include_once("../authorization-header.php");
include_once("../sql/sql.php");

$credentials = getCredentialsFromHeader();
$sql = new Sql();
if($sql->login($credentials)){
  $games = $sql->getMyGames();
  echo json_encode($games);
}
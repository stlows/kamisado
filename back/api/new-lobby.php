<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../errors.php");

$settings = json_decode(file_get_contents('php://input'), true);

$pointsToWin = $settings["pointsToWin"];
checkId($pointsToWin);

$accepted = [1, 3, 7, 15];
if(in_array($pointsToWin, $accepted)){
  $sql = new Sql();
  $lobby_id = $sql->newLobby($pointsToWin);

  echo $lobby_id;
  exit;
}else{
  echo(json_encode($UNEXPECTED_VALUE_POINTS_TO_WIN));
  exit;
}



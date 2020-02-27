<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$lobbyId = $settings["lobbyId"];
checkId($lobbyId);

$sql = new Sql();
$result = $sql->deleteLobby($lobbyId);
if($result){
  echo "DELETED";
  exit;
}else{
  echo "ERROR DELETING LOBBY";
  exit;
}




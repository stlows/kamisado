<?php

include_once("../check-post.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$settings = json_decode(file_get_contents('php://input'), true);

$gameId = $settings["gameId"];
checkId($gameId);

$sql = new Sql();
if($sql->forfeit($gameId)){
  echo "FORFEITED";
  exit;
}else{
  echo("ERROR FORFEITING");
  exit;
}

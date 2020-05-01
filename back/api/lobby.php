<?php
include_once("../check-get.php");
include_once("../check-id.php");
include_once("../check-token.php");
include_once("../sql/sql.php");

$credentials = getCredentialsFromHeader();
$sql = new Sql();
if($sql->login($credentials)){
  $lobby = $sql->getAllLobby();
  echo (json_encode($lobby));
}


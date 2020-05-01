<?php
include_once("../check-get.php");
include_once("../sql/sql.php");

$sql = new Sql();
$lobby = $sql->getAllLobby();
echo (json_encode($lobby));


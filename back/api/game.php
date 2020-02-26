<?php

include_once("../check-get.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$sql = new Sql();

$game = $sql->getGame($_GET["gameId"]);

echo (json_encode($game));

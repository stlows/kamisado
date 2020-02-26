<?php

include_once("../check-get.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$sql = new Sql();
$tower = $sql->getTower($_GET["towerId"]);

echo (json_encode($tower));

<?php

include_once("../check-get.php");
include_once("../check-id.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$towerId = isset($_GET["towerId"]) ? (int)$_GET["towerId"] : "";

checkId($towerId);

$sql = new Sql();
$tower = $sql->getTower($towerId);

echo (json_encode($tower));

<?php

include_once("../check-get.php");
include_once("../sql/sql.php");

$sql = new Sql();
$tiles = $sql->getTiles();

echo (json_encode($tiles));

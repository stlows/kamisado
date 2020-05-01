<?php

include_once("../check-get.php");
include_once("../authorization-header.php");
include_once("../sql/sql.php");

$sql = new Sql();
$games = $sql->getMyGames();

echo json_encode($games);

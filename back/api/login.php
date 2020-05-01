<?php

include_once("../check-post.php");
include_once("../sql/sql.php");

$credentials = json_decode(file_get_contents('php://input'), true);

$sql = new Sql();
$sql->login($credentials);

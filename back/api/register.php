<?php

include_once("../check-post.php");
include_once("../sql/sql.php");

$credentials = json_decode(file_get_contents('php://input'), true);

$sql = new Sql();
$user_id = $sql->register($credentials);
$sql->generate_verified_code($user_id);
echo (json_encode($user_id));

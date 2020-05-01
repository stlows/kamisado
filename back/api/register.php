<?php

include_once("../check-post.php");
include_once("../sql/sql.php");
include_once("../email-sender.php");
include_once("../constants.php");

$credentials = json_decode(file_get_contents('php://input'), true);

$sql = new Sql();
$user_id = $sql->register($credentials);
$code = $sql->generate_verified_code($user_id);

send_email($credentials["email"], "Your validation code is: $code", $VERIFY_EMAIL_BODY);

echo (json_encode($user_id));

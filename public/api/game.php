<?php

include_once("../../includes/check-get.php");
include_once("../../includes/sql.php");

$game = getGame($_GET["gameId"]);

echo (json_encode($game));

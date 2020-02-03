<?php

include_once("../check-get.php");
include_once("../sql.php");

$game = getGame($_GET["gameId"]);

echo (json_encode($game));

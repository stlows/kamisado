<?php

include_once("../check-get.php");
include_once("../sql.php");

$lobby = getAllLobby();

echo (json_encode($lobby));

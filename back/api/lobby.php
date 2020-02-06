<?php

include_once("../check-get.php");
include_once("../sql.php");

$lobby = getAllLobby();
// apache_request_headers()
echo (json_encode($lobby));

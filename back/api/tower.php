<?php

include_once("../check-get.php");
include_once("../check-google-token.php");
include_once("../sql/sql.php");

$tower = getTower($_GET["towerId"]);

echo (json_encode($tower));

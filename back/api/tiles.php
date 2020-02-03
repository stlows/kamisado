<?php

include_once("../check-get.php");
include_once("../sql.php");

$tiles = getTiles();

echo (json_encode($tiles));

<?php

include_once("../check-get.php");
include_once("../sql/sql.php");

$tiles = getTiles();

echo (json_encode($tiles));

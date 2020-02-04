<?php

include_once("../../includes/check-get.php");
include_once("../../includes/sql.php");

$tiles = getTiles();

echo (json_encode($tiles));

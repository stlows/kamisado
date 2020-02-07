<?php
include_once("errors.php");

header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
  echo (json_encode($ONLY_GET));
  exit;
}

<?php
include_once "errors.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo (json_encode($ONLY_POST));
  exit;
}

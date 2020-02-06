<?php
header('Access-Control-Allow-Origin: *');
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
  $error = [
    "error" => 5001,
    "message" => "Only GET requests allowed."
  ];
  echo (json_encode($error));
  exit;
}

<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'Origin, X-Requested-With, Content-Type, Accept'");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
  $error = [
    "error" => 5001,
    "message" => "Only GET requests allowed."
  ];
  echo (json_encode($error));
  exit;
}

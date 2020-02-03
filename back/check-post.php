<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'Origin, X-Requested-With, Content-Type, Accept'");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $error = [
    "error" => 5000,
    "message" => "Only POST requests allowed."
  ];
  echo (json_encode($error));
  exit;
}

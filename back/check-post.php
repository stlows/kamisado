<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  $error = [
    "error" => 5000,
    "message" => "Only POST requests allowed."
  ];
  echo (json_encode($error));
  exit;
}

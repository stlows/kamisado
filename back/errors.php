<?php

$ONLY_POST = [
  "error" => 5000,
  "message" => "Only POST requested are allowed."
];

$ONLY_GET = [
  "error" => 5001,
  "message" => "Only GET requested are allowed."
];

$UNHANDLED = [
  "error" => 5002,
  "message" => "Unhandled error."
];

$NO_AUTHORIZATION_HEADER = [
  "error" => 5003,
  "message" => "No authorization header."
];

$CANT_AUTHENTICATE  = [
  "error" => 5004,
  "message" => "Can't authenticate user."
];

$CANT_JOIN_YOUR_OWN_GAME  = [
  "error" => 5005,
  "message" => "Can't join your own game."
];

$NO_GAME_FOUND  = [
  "error" => 5006,
  "message" => "No game found with this ID."
];

$GAME_DOESNT_HAVE_SIXTEEN_TOWERS  = [
  "error" => 5007,
  "message" => "This game doesn't have 16 towers."
];

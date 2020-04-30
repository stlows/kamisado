<?php

$ONLY_POST = [
  "error" => 5000,
  "message" => "Only POST requested are allowed"
];

$ONLY_GET = [
  "error" => 5001,
  "message" => "Only GET requested are allowed"
];

$UNHANDLED = [
  "error" => 5002,
  "message" => "Unhandled error"
];

$NO_AUTHORIZATION_HEADER = [
  "error" => 5003,
  "message" => "No authorization header"
];

$CANT_AUTHENTICATE  = [
  "error" => 5004,
  "message" => "Can't authenticate user"
];

$CANT_JOIN_YOUR_OWN_GAME  = [
  "error" => 5005,
  "message" => "Can't join your own game"
];

$NO_GAME_FOUND  = [
  "error" => 5006,
  "message" => "No game found with this ID"
];

$GAME_DOESNT_HAVE_SIXTEEN_TOWERS  = [
  "error" => 5007,
  "message" => "This game doesn't have 16 towers"
];

$ERROR_MOVING_TOWER  = [
  "error" => 5008,
  "message" => "Error moving your tower"
];

$ERROR_UPDATING_GAME  = [
  "error" => 5009,
  "message" => "Error updating game"
];

$UNEXPECTED_VALUE = [
    "error" => 5010,
    "message" => "Unexpected value in request"
];

$UNEXPECTED_VALUE_POINTS_TO_WIN = [
  "error" => 5011,
  "message" => "Unexpected pointsToWin value. Accepted values are 1, 3, 7 and 15"
];

$EMAIL_ALREADY_USED = [
  "error" => 5012,
  "message" => "Already a user registered using that email"
];

$USERNAME_TAKEN = [
  "error" => 5013,
  "message" => "Username already taken"
];

$WRONG_CODE = [
  "error" => 5014,
  "message" => "Wrong code"
];

$CODE_EXPIRED = [
  "error" => 5015,
  "message" => "Code expired"
];

$EMAIL_NOT_VERIFED = [
  "error" => 5016,
  "message" => "Email is not verified"
];

$WRONG_CREDENTIALS = [
  "error" => 5017,
  "message" => "Wrong credentials"
];


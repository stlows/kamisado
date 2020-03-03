<?php

include_once 'google-api-php-client-2.4.0/vendor/autoload.php';
include_once 'errors.php';

$headers = apache_request_headers();
$headers = array_change_key_case($headers);
try {
  if (!isset($headers["authorization"])) {
    echo json_encode($NO_AUTHORIZATION_HEADER);
    exit;
  }
  if ($headers["authorization"] == "" || $headers["authorization"] == null) {
    echo json_encode($NO_AUTHORIZATION_HEADER);
    exit;
  }
  $id_token = $headers["authorization"];

  // Pour développement seulement !
  if (strpos($id_token, "test") !== false) {
    $_SESSION["google_id"] = $id_token;
    $_SESSION["google_name"] = $id_token;
  } else {
    $client_ID = "337034590956-hhm2gfgqr5khkh7qr4ho3itm669gprcd.apps.googleusercontent.com";
    $client = new Google_Client(['client_id' => $client_ID]);
    $payload = $client->verifyIdToken($id_token);
    if ($payload) {
      $_SESSION["google_id"] = $payload['sub'];
      $_SESSION["google_name"] = $payload['given_name'];
    } else {
      echo json_encode($CANT_AUTHENTICATE);
      exit;
    }
  }
} catch (UnexpectedValueException $ex) {
  echo json_encode($UNEXPECTED_VALUE);
  exit;
}catch (Exception $ex){
  echo json_encode($UNHANDLED);
  exit;
}

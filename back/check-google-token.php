<?php

include_once 'google-api-php-client-2.4.0/vendor/autoload.php';
include_once 'errors.php';

$headers = apache_request_headers();
try {
  if (!isset($headers["Authorization"])) {
    echo json_encode($NO_AUTHORIZATION_HEADER);
    exit;
  }
  if ($headers["Authorization"] == "" || $headers["Authorization"] == null) {
    echo json_encode($NO_AUTHORIZATION_HEADER);
    exit;
  }
  $id_token = $headers["Authorization"];

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
} catch (Exception $ex) {
  // echo $ex;
  echo json_encode($UNHANDLED);
  exit;
}

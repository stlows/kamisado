<?php

include_once 'errors.php';
session_start();

function getCredentialsFromHeader(){
  global $CANT_AUTHENTICATE, $UNEXPECTED_VALUE, $UNHANDLED;
  $headers = apache_request_headers();
  $headers = array_change_key_case($headers);
  try {
    if (isset($headers["authorization"]) && $headers["authorization"] != "" && $headers["authorization"] != null) {
      $authorization = $headers["authorization"];
      $exploded_authorization = explode(" ", $authorization);
      if(count($exploded_authorization) == 2 && $exploded_authorization[0] == "Basic"){
          $key = base64_decode($exploded_authorization[1]);
          $exploded_key = explode(":", $key);
          if(count($exploded_key) == 2){
            $username = $exploded_key[0];
            $password = $exploded_key[1];
            return [
              "email" => $username,
              "password" => $password
            ];
          }
          
      }
    }
    echo json_encode($CANT_AUTHENTICATE);
    exit;
    
  } catch (UnexpectedValueException $ex) {
    echo json_encode($UNEXPECTED_VALUE);
    exit;
  }catch (Exception $ex){
    echo json_encode($UNHANDLED);
    exit;
  }
}



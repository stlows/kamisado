<?php
include_once("errors.php");

function checkId($id){
  if(is_int($id)){
    return;
  }else{
    global $UNEXPECTED_VALUE;
    echo(json_encode($UNEXPECTED_VALUE));
    exit;
  }
}

<?php
include_once("errors.php");

function checkId($id){
  if(is_int($id) && $id > 0){
    return;
  }else{
    global $UNEXPECTED_VALUE;
    echo(json_encode($UNEXPECTED_VALUE));
    exit;
  }
}

function checkInt($int){
  if(is_int($int)){
    return;
  }else{
    global $UNEXPECTED_VALUE;
    echo(json_encode($UNEXPECTED_VALUE));
    exit;
  }
}

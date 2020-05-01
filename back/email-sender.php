<?php

function send_email($to, $object, $body){

  mail($to, $object, $body, "From: Kamisado Game <kamisado@vbeaulieu.com>");

}
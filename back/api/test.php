<?php
include_once("../check-google-token.php");
include_once("../sql/sql.php");
include_once("../board.php");

$sql = new Sql();
$game = $sql->getGame(75);
$board = new Board($game["towers"]);
var_dump($board->emptySpacesOnRow(2));
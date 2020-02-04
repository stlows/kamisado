<?php
function getNewConn()
{
  $conn = new mysqli("localhost", "root", "", "kamisado");
  $conn->set_charset("utf8");
  return $conn;
}

function newGame($player_1_id, $player_2_id, $points_to_win)
{
  $conn = getNewConn();

  $gameQuery = "
  INSERT INTO games
  (player_1_id, player_2_id, player_1_score, player_2_score, points_to_win, is_first_move, tower_id_to_move)
  VALUES
  ($player_1_id, $player_2_id, 0, 0, $points_to_win, true, null)";

  $conn->query($gameQuery);

  $game_id = $conn->insert_id;

  $towersQuery = "
  INSERT INTO towers
  (game_id,tower_color,player_color,position_x,position_y,sumo,symbol)
  VALUES
  ($game_id,'orange','white',1,1,0,'주'),
  ($game_id,'blue','white',2,1,0,'푸'),
  ($game_id,'indigo','white',3,1,0,'남'),
  ($game_id,'pink','white',4,1,0,'담'),
  ($game_id,'yellow','white',5,1,0,'노'),
  ($game_id,'red','white',6,1,0,'빨'),
  ($game_id,'green','white',7,1,0,'녹'),
  ($game_id,'brown','white',8,1,0,'갈'),
  ($game_id,'brown','black',1,8,0,'갈'),
  ($game_id,'green','black',2,8,0,'녹'),
  ($game_id,'red','black',3,8,0,'빨'),
  ($game_id,'yellow','black',4,8,0,'노'),
  ($game_id,'pink','black',5,8,0,'담'),
  ($game_id,'indigo','black',6,8,0,'남'),
  ($game_id,'blue','black',7,8,0,'푸'),
  ($game_id,'orange','black',8,8,0,'주')
  ";
  $conn->query($towersQuery);
  return $game_id;
}

function getGame($game_id)
{
  $conn = getNewConn();
  $gameQuery = "SELECT * FROM games WHERE game_id = $game_id";

  $gameResult = $conn->query($gameQuery);

  if ($gameResult->num_rows > 1) {
  } else if ($gameResult->num_rows == 0) {
  } else {
    $game = $gameResult->fetch_assoc();
    $towersQuery = "SELECT * FROM towers WHERE game_id = $game_id";

    $towersResult = $conn->query($towersQuery);

    if ($towersResult->num_rows == 16) {
      $towers = $towersResult->fetch_all(MYSQLI_ASSOC);
      return [
        "game" => $game,
        "towers" => $towers
      ];
    } else {
    }
  }
}

function getTower($tower_id)
{
  $conn = getNewConn();
  $towerQuery = "SELECT * FROM towers WHERE tower_id = $tower_id";

  $towerResult = $conn->query($towerQuery);

  if ($towerResult->num_rows > 1) {
  } else if ($towerResult->num_rows == 0) {
  } else {
    return $towerResult->fetch_assoc();
  }
}

function getTiles()
{
  $conn = getNewConn();
  $query = "SELECT * FROM tiles";

  $result = $conn->query($query);

  if ($result->num_rows != 64) {
  } else {
    return $result->fetch_all(MYSQLI_ASSOC);
  }
}

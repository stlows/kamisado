<?php
class Board
{

  public $tiles;

  function __construct($towers)
  {

    for($y = 1; $y <=8 ; $y++){
      for($x = 1; $x <= 8; $x++){
        $this->tiles[$x][$y] = [];
      }
    }

    foreach($towers as $tower){
      $this->tiles[$tower["position_x"]][$tower["position_y"]] = $tower;
    }
    
  }

  function move($fromX, $fromY, $toX, $toY){
    $this->$tiles[$toX][$toY] = $this->tiles[$fromX][$fromY];
    $this->tiles[$fromX][$fromY] = []
  }

  function towers(){
    $result = [];
    for($y = 1; $y <=8 ; $y++){
      for($x = 1; $x <= 8; $x++){
        if($this->tiles[$x][$y] != []){
          $result[] = $this->tiles[$x][$y];
        }
      }
    }
    return $result;
  }
  
  function replaceBlacks($dir){
    for($y = 1; $y <= 8; $y++){
      for($x = 1; $x <= 8; $x++){
        if($this->tiles[$x][$y] != [] && $this->tiles[$x][$y]["player_color"] == "black"){
          if($dir == "left"){
            for($z = 1; $z <= 8; $z++){
              if($this->tiles[$z][8] == []){
                $temp = $this->tiles[$x][$y];
                $temp["position_x"] = $z;
                $temp["position_y"] = 8;
                $this->tiles[$z][8] = $temp;
                $this->tiles[$x][$y] = [];
                break;
              }
            }
          }else if($dir == "right"){
            for($z = 8; $z >= 1; $z--){
                if($this->tiles[$z][8] == []){
                $temp = $this->tiles[$x][$y];
                $temp["position_x"] = $z;
                $temp["position_y"] = 8;
                $this->tiles[$z][8] = $temp;
                $this->tiles[$x][$y] = [];
                break;
              }
            }
          }

        }
      }
    }
  }

  function replaceWhites($dir){
    for($y = 8; $y >= 1; $y--){
      for($x = 8; $x >= 1; $x--){
        if($this->tiles[$x][$y] != [] && $this->tiles[$x][$y]["player_color"] == "white"){
          if($dir == "left"){
            for($z = 8; $z >= 1; $z--){
              if($this->tiles[$z][1] == []){
                $temp = $this->tiles[$x][$y];
                $temp["position_x"] = $z;
                $temp["position_y"] = 1;
                $this->tiles[$z][1] = $temp;
                $this->tiles[$x][$y] = [];
                break;
              }
            }
          }else if($dir == "right"){
            for($z = 1; $z <= 8; $z++){
              if($this->tiles[$z][1] == []){
                $temp = $this->tiles[$x][$y];
                $temp["position_x"] = $z;
                $temp["position_y"] = 1;
                $this->tiles[$z][1] = $temp;
                $this->tiles[$x][$y] = [];
                break;
              }
            }
          }
          
        }
      }
    }
  }
}

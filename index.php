<!doctype html>
<html lang="en">

<head>
    <title>The Maze</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./assets/css/style.css" rel="stylesheet" />
</head>


<?php

session_start();

echo "<body>";
echo "<header><h1>THE GREATEST MAZE</h1></header>";
echo "<main>";
// W = wall; F = fog; C = Cat; E = Empty; M = Mouse
$arrOne = [
    ["E", "W", "E", "E", "E", "W"],
    ["E", "W", "E", "W", "W", "W"],
    ["E", "E", "E", "W", "M", "W"],
    ["E", "W", "E", "W", "E", "E"],
    ["E", "W", "E", "E", "W", "E"],
    ["E", "E", "W", "E", "E", "E"],
];

$arrTwo = [
    ["C", "W", "E", "E", "E", "W"],
    ["E", "W", "E", "W", "W", "W"],
    ["E", "E", "E", "W", "M", "W"],
    ["E", "W", "E", "W", "E", "E"],
    ["E", "W", "E", "E", "W", "E"],
    ["E", "E", "W", "E", "E", "E"],
];

if(!isset($_SESSION["arrDisplay"])){
    $_SESSION["arrDisplay"] = [
        ["C", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
    ];

}

if (!isset($_SESSION["catPos"])) {
    $_SESSION["catPos"] = catPosition($_SESSION["arrDisplay"]);
}

echo "<div id='mazeContainer'>";

function showCell($cell){
            switch ($cell) {
                case 'W':
                    echo "<img src='./assets/images/wall.png' width='96'>";
                    break;
                case 'F':
                    echo "<img src='./assets/images/fog.png' width='96'>";
                    break;
                case 'C':
                    echo "<img src='./assets/images/cat.png' width='96'>";
                    break;
                case 'M':
                    echo "<img src='./assets/images/mouse.png' width='96'>";
                    break;
                case 'E':
                    echo "";
                    break;
            }
}

function catPosition($array){
    $catPos = [];
    foreach ($array as $y => $row) {
        foreach($row as $x => $cell){
            if($cell == "C"){
                $catPos[] = $x;
                $catPos[] = $y;
                return $catPos;
            }
        }
    }
}


function enlight($array, $arrayDisp, $catPos){
    $x = $catPos[0];
    $y = $catPos[1];
    if($y != 0) $arrayDisp[$y-1][$x] = $array[$y-1][$x];
    if($x != count($array[$y])-1) $arrayDisp[$y][$x+1] = $array[$y][$x+1];
    if($y != count($array)-1) $arrayDisp[$y+1][$x] = $array[$y+1][$x];
    if($x != 0) $arrayDisp[$y][$x-1] = $array[$y][$x-1];
    return $arrayDisp;
}

function drawMaze($array){
    foreach ($array as $y => $row) {
        echo "<div class='row'>";
        foreach($row as $x => $cell){
            echo "<div class='cell' width='96' height='96'>";
            showCell($cell);
            echo "</div>";
        }
        echo "</div>";
    }
}

function move($arr, $catPos){
    $x = $catPos[0];
    $y = $catPos[1];
    if(isset($_POST["up"])) {
        if($y != 0 && $arr[$y-1][$x] != "W"){
            // $arr[$y][$x] = "E";
            $arr[$y-1][$x] = "C";
            $_SESSION["catPos"][1]--;
            return $arr;
        } 
    }
    if(isset($_POST["right"])){
        if($x != count($arr[$y]) - 1 && $arr[$y][$x+1] !="W"){
            // $arr[$y][$x] = "E";
            $arr[$y][$x+1] = "C";
            $_SESSION["catPos"][0]++;
            return $arr;
        } 
    };
    if(isset($_POST["down"])) {
        if($y != count($arr) - 1 && $arr[$y+1][$x] != "W"){
            // $arr[$y][$x] = "E";
            $arr[$y+1][$x] = "C";
            $_SESSION["catPos"][1]++;
            return $arr;
        } 
    };
    if(isset($_POST["left"])){
        if($x != 0 && $arr[$y][$x-1] != "W"){
            // $arr[$y][$x] = "E";
            $arr[$y][$x-1] = "C";
            $_SESSION["catPos"][0]--;
            return $arr;
        } 
    }
    return $arr;
}

$_SESSION["arrDisplay"] = move($_SESSION["arrDisplay"], $_SESSION["catPos"]);
$_SESSION["arrDisplay"] = enlight($arrOne, $_SESSION["arrDisplay"], $_SESSION["catPos"]);
drawMaze($_SESSION["arrDisplay"]);


echo "</div>";
echo "<div id='arrowContainer'>";
echo "
<form method='POST'>
    <div>
        <input type='submit' name='up' value='up'>
    </div>
    <div>
        <input type='submit' name='left' value='left'>
        <input type='submit' name='right' value='right'>
    </div>
    <div>
        <input type='submit' name='down' value='down'>
    </div>
</form>
";
echo "</div>";


echo "</main>";
echo "</body>";
?>

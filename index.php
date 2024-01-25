<!doctype html>
<html lang="en">

<head>
    <title>The Maze</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./assets/css/style.css" rel="stylesheet" />
</head>


<body>
    <header>
        <h1>THE GREATEST MAZE</h1>
    </header>
<main>

<?php

session_start();

// W = wall; F = fog; C = Cat; E = Empty; M = Mouse
$arrOne = [
    ["E", "W", "E", "E", "E", "E"],
    ["E", "W", "E", "W", "W", "W"],
    ["E", "E", "E", "W", "M", "W"],
    ["E", "W", "E", "W", "E", "E"],
    ["E", "W", "E", "E", "W", "E"],
    ["E", "E", "W", "E", "E", "E"],
];

$arrTwo = [
    ["E", "W", "E", "E", "E", "W"],
    ["E", "W", "E", "W", "W", "W"],
    ["E", "E", "E", "W", "M", "W"],
    ["E", "W", "E", "W", "E", "E"],
    ["E", "W", "E", "E", "W", "E"],
    ["E", "E", "W", "E", "E", "E"],
];

$displayedArr = [
    ["F", "F", "F", "F", "F", "F"],
    ["F", "F", "F", "F", "F", "F"],
    ["F", "F", "F", "F", "F", "F"],
    ["F", "F", "F", "F", "F", "F"],
    ["F", "F", "F", "F", "F", "F"],
    ["F", "F", "F", "F", "F", "F"],
];



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

function enlight($array, $arrayDisp, $catPos){
    $x = $catPos[0];
    $y = $catPos[1];
    $arrayDisp[$y][$x] = "C";
    if($y != 0) $arrayDisp[$y-1][$x] = $array[$y-1][$x];
    if($x != count($array[$y])-1) $arrayDisp[$y][$x+1] = $array[$y][$x+1];
    if($y != count($array)-1) $arrayDisp[$y+1][$x] = $array[$y+1][$x];
    if($x != 0) $arrayDisp[$y][$x-1] = $array[$y][$x-1];
    return $arrayDisp;
}

function drawMaze($array){
    echo "<div id='mazeContainer'>";
        foreach ($array as $y => $row) {
            echo "<div class='row'>";
            foreach($row as $x => $cell){
                echo "<div class='cell' width='96' height='96'>";
                showCell($cell);
                echo "</div>";
            }
            echo "</div>";
        }
    echo "</div>";
}

function move($arr, $arrDisp, $catPos){
    $x = $catPos[0];
    $y = $catPos[1];
    if(isset($_POST["up"])) {
        if($y != 0 && $arr[$y-1][$x] != "W"){
            $arrDisp[$y-1][$x] = "C";
            $_SESSION["catPos"][1]--;
            return $arrDisp;
        } 
    }
    if(isset($_POST["right"])){
        if($x != count($arr[$y]) - 1 && $arr[$y][$x+1] !="W"){
            $arrDisp[$y][$x+1] = "C";
            $_SESSION["catPos"][0]++;
            return $arrDisp;
        } 
    };
    if(isset($_POST["down"])) {
        if($y != count($arr) - 1 && $arr[$y+1][$x] != "W"){
            $arrDisp[$y+1][$x] = "C";
            $_SESSION["catPos"][1]++;
            return $arrDisp;
        } 
    };
    if(isset($_POST["left"])){
        if($x != 0 && $arr[$y][$x-1] != "W"){
            $arrDisp[$y][$x-1] = "C";
            $_SESSION["catPos"][0]--;
            return $arrDisp;
        } 
    }
    return $arrDisp;
}

// Placing cat for first launch
if (!isset($_SESSION["catPos"])) {
    $_SESSION["catPos"] = [0, 0];
    $displayedArr[$_SESSION["catPos"][0]][$_SESSION["catPos"][1]] = "C";
}

// Checking move input
$displayedArr = move($arrOne, $displayedArr, $_SESSION["catPos"]);
// Removing fog
$displayedArr = enlight($arrOne, $displayedArr, $_SESSION["catPos"]);
// Draw the maze
drawMaze($displayedArr);

?>

<div id='arrowContainer'>

<form method='POST'>
    <div>
        <input id='up' class:'arrow' type='submit' name='up' value=''>
    </div>
    <div>
        <input id='left' class:'arrow' type='submit' name='left' value=''>
        <input id='right' class:'arrow' type='submit' name='right' value=''>
    </div>
    <div>
        <input id='down' class:'arrow' type='submit' name='down' value=''>
    </div>
</form>
</div>


</main>
</body>

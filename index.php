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
    if (isset($_POST["reload"])){
        unset($_SESSION);
    }

    // W = wall; F = fog; C = Cat; E = Empty; M = Mouse
    $displayedArr = [
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
        ["F", "F", "F", "F", "F", "F"],
    ];


    function randArr(){
        $arrs = [
            [
                ["E", "W", "E", "E", "E", "E"],
                ["E", "W", "E", "W", "W", "W"],
                ["E", "E", "E", "W", "M", "W"],
                ["E", "W", "E", "W", "E", "E"],
                ["E", "W", "E", "E", "W", "E"],
                ["E", "E", "W", "E", "E", "E"],
            ],
            [
                ["E", "E", "E", "E", "E", "W"],
                ["W", "W", "E", "W", "W", "W"],
                ["E", "E", "E", "W", "M", "E"],
                ["E", "W", "W", "W", "W", "E"],
                ["E", "W", "E", "E", "E", "E"],
                ["E", "E", "E", "W", "W", "W"],
            ],
        ];
        return $arrs[rand(0,1)];
    }

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
    // Reloading button
    if (isset($_POST["reload"])){
        session_destroy();
    }
    // Chose a random maze
    if (!isset($_SESSION["maze"])){
        $_SESSION["maze"] = randArr();
    }

    // Placing cat for first launch
    if (!isset($_SESSION["catPos"])) {
        $_SESSION["catPos"] = [0, 0];
        $displayedArr[$_SESSION["catPos"][0]][$_SESSION["catPos"][1]] = "C";
    }

    // Checking move input
    $displayedArr = move($_SESSION["maze"], $displayedArr, $_SESSION["catPos"]);
    // Removing fog
    $displayedArr = enlight($_SESSION["maze"], $displayedArr, $_SESSION["catPos"]);
    // Draw the maze
    drawMaze($displayedArr);

?>


<form method='POST'>
    <div id='arrowContainer'>
        <div>
            <input id='up' class='arrow' type='submit' name='up' value=''>
        </div>
        <div>
            <input id='left' class='arrow' type='submit' name='left' value=''>
            <input id='right' class='arrow' type='submit' name='right' value=''>
        </div>
        <div>
            <input id='down' class='arrow' type='submit' name='down' value=''>
        </div>
    </div>
    <div>
        <input id='reload' type='submit' name='reload' value='Reload'>
    </div>
</form>


</main>
</body>

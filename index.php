<!doctype html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./assets/css/style.css" rel="stylesheet" />
</head>


<?php

echo "<body>";
echo "<header><h1>THE GREATEST MAZE</h1></header>";
echo "<main>";
// W = wall; F = fog; C = Cat; E = Empty; M = Mouse
$arrOne = [
    ["C", "W", "E", "E", "E", "W"],
    ["F", "W", "E", "W", "W", "W"],
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

echo "<div id='mazeContainer'>";

function console_log($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
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

function cellsAround($array, $x, $y){
    $cellsArd = [];
    $y != 0 ? $cellsArd["up"] = $array[$y-1][$x] : $cellsArd["up"] = "out";
    $x != count($array[$y])-1 ? $cellsArd["right"]= $array[$y][$x+1] : $cellsArd["right"] = "out";
    $y != count($array)-1 ? $cellsArd["down"] = $array[$y+1][$x] : $cellsArd["down"] = "out";
    $x != 0 ? $cellsArd["left"] = $array[$y][$x-1] : $cellsArd["left"] = "out";
    return $cellsArd;
}

function drawMaze($array){
    foreach ($array as $x => $row) {
        echo "<div class='row'>";
        foreach($row as $y => $cell){
            echo "<div class='cell' width='96' height='96'>";
            if ($cell === "C"){
                console_log(cellsAround($array, $x, $y));
            }
            showCell($cell);
            echo "</div>";
        }
        echo "</div>";
    }
}


drawMaze($arrOne);

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

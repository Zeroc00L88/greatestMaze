<?php

echo "<body>";
echo "<h1>THE GREATEST MAZE</h1>";
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
    ["E", "W", "E", "E", "E", "W"],
    ["E", "W", "E", "W", "W", "W"],
    ["E", "E", "E", "W", "M", "W"],
    ["E", "W", "E", "W", "E", "E"],
    ["E", "W", "E", "E", "W", "E"],
    ["E", "E", "W", "E", "E", "E"],
];

echo "<div id='mazeContainer'>";

function drawMaze($array){
    foreach ($array as $row) {
        echo "<div class='row'>";
        foreach($row as $cell){
            echo "<div class='cell' width='96' height='96'>";
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
</form>
";
echo "</div>";

echo "
<style>
    h1 {
        display: flex;
        justify-content: center;
    }
    .row {
        display: flex;
    }
    .cell {
        width: 96px;
    }
    #mazeContainer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; 
        border: 1px solid black;
        max-width: 100%;
    }
</style>
";
echo "</body>";
?>

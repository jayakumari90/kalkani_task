<?php
if(isset($_POST['pattern_no']) && !empty($_POST['pattern_no'])){
    $size = $_POST['pattern_no'];
    $alpha = range('A','Z');
    for($i = 1; $i <= $size; $i++) {
        // print spaces
        for($j = 1; $j <= $size - $i; $j++) {
        echo "&nbsp;&nbsp;";
        }
        // print stars
        for($k = 1; $k <= $i; $k++) {
            if($k%2 != 0){
                echo $k;
            } 
        }
        if($i > 1){
        for($l = 1; $l <= $i; $l++) {
                echo $alpha[$l-1];
        }
        }
        echo "<br>";
    }
    for($i = $size-1; $i >= 1; $i--) {
        // print spaces
        for($j = $size - $i; $j >= 1; $j--) {
        echo "&nbsp;&nbsp;";
        }
        // print stars
        for($k = $i; $k >= 1; $k--) {
            if($k%2 != 0){
                echo $k;
            } 
        }
        if($i > 1){
        for($l = 1; $l <= $i; $l++) {
                echo $alpha[$l-1];
        }
        }
        echo "<br>";
    }
}

?>
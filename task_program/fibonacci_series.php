<?php
if(isset($_POST['pattern_no']) && !empty($_POST['pattern_no'])){
    $number = 0;
    $size = $_POST['pattern_no'];
    $no1 = 0;
    $no2=1;
    echo $no1.', '.$no2;
    
    while($number < $size){
        $no3 = $no2+$no1;
        echo ",".$no3;
        $no1 = $no2;
        $no2 = $no3;
        $number = $number + 1;
    }
}

?>
<?php 
    function fake($a, $max, $min) {
        $ans = $a;
        if ($a >= $max){
            $ans = $a - 1.5 * ($a - $max);
            // echo "max \t".($a - 1.5* $max)."<br>";
        }
        else if ($a < $min){
            $ans = $a + 1.5 * ($min - $a);
            // echo "min \t". ($min - $a)."<br>";
        }
        // echo $ans."<br>";
        $ans = number_format($ans, 1);
        return $ans;
    }
?>
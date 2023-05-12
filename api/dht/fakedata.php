<?php 
    function fake($a, $max, $min) {
        $ans = $a;
        if ($ans >= $max){
            $ans = $ans * ($ans - $max);
            // echo "max \t".($a - 1.5* $max)."<br>";
        }
        if ($ans < $min){
            $ans = $ans * ($min - $ans);
            // echo "min \t". ($min - $a)."<br>";
        }
        // echo $ans."<br>";
        $ans = number_format($ans, 1);
        return $ans;
    }
?>
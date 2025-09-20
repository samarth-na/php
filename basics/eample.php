<?php
function func(){
    static $a;
    
    $b = 0; 
    $a++;
    $b++;
    echo "$a $b";
    echo "\n";
}
func();
func();
func();
func();
echo "today is ".date("Y-m-d");
?>



<?php 
$z=100;
   function sum($a,$b){ 
       return $a+$b;
   }
   function sub($a,$b){
       return $a-$b;
   }
   function mul($a,$b){
       return $a*$b;
   }
   function div($a,$b){
       return $a/$b;
   }
   function squire($a){
       return $a*$a;
   }

   echo "The sum is ". sum($z,$z)." <br>";
   echo "The mul is ". mul(1,4)." <br>";
   echo "The div is ". div(110,4)." <br>";
   echo "The sub is ". sub(110,4)." <br>";
   echo "The squire is ". squire(3)." <br>";
?>
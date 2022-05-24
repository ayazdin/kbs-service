<?php
$option = 'a:3:{i:0;s:1:"3";i:1;s:2:"22";i:2;s:1:"8";}';
$option2 = 'a:3:{i:0;s:1:"3";i:1;s:2:"22";i:2;s:1:"8";}';
$arrtemp = array();
$arr1=array('prodid' => 2, 'options' => $option, 'qty' => 4, 'status' => 'publish');
$arr2=array('prodid' => 2, 'options' => $option2, 'qty' => 3, 'status' => 'publish');
array_push($arrtemp, $arr1);
print_r($arrtemp);echo "<br>";
array_push($arrtemp, $arr2);
print_r($arrtemp);
?>

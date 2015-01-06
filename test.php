<?php 
$SharpeRatio='';

$SharpeRatio=str_replace("(", "-", $SharpeRatio);
$SharpeRatio=str_replace(")", "", $SharpeRatio);


$SharpeRatioT=floatval($SharpeRatio);

echo $SharpeRatioT;


?>
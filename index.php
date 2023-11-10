<?php
require './vendor/autoload.php';

use WordifyNumber\Words\Locale\Fr;

$fr = new Fr();

//Test For wordsForThreeDigitGroup

// $myfile = fopen("tests/testfile.txt", "w");
// for ($i = 0; $i <= 999; $i++) {
//     fwrite($myfile, $fr->wordsForThreeDigitGroup($i) . "\r");
// }
// fclose($myfile);
// echo $fr->wordsForThreeDigitGroup(999);
//End Test For wordsForThreeDigitGroup


var_dump($fr->getExponents($fr->splitNumber(1524000000000)));
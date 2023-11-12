<?php
require './vendor/autoload.php';

use WordifyNumber\Words\Locale\Fr;

$fr = new Fr();

//Test For wordsForThreeDigitGroup

$myfile = fopen("tests/testfile.txt", "w");
for ($i = 0; $i <= 999; $i++) {
    fwrite($myfile, $fr->toWords($i) . "\r");
}
fclose($myfile);
//End Test For wordsForThreeDigitGroup


var_dump($fr->toWords(201000));

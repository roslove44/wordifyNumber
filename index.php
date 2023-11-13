<?php
require './vendor/autoload.php';

use WordifyNumber\Words\Locale\Fr;

$numbersToTest = [
    123,
    456,
    789,
    1000,
    1500,
    9999,
    10000,
    12000,
    19999,
    20000,
    50000,
    99999,
    100000,
    150000,
    999999,
    1000000,
    1500000,
    2000000,
    9999999,
    10000000,
];

$fr = new Fr();

//Test For wordsForThreeDigitGroup

$myfile = fopen("tests/testfile.txt", "w");
for ($i = 0; $i < count($numbersToTest); $i++) {
    fwrite($myfile, $fr->toWords($numbersToTest[$i]) . "\r");
}
fclose($myfile);
//End Test For wordsForThreeDigitGroup


var_dump($fr->toWords(201));

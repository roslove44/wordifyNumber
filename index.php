<?php

use WordifyNumber\WordifyNumber;

require './vendor/autoload.php';


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

$wordify = new WordifyNumber();

echo $wordify::transformCurrency(10889777);

<?php

namespace WordifyNumber\NumberTransformer;

use WordifyNumber\Words\Words;

class FrenchNumberTransformer implements NumberTransformer
{
    public function toWords(int $number): string
    {
        $converter = new Words();

        return $converter->transformToWords($number, 'fr');
    }
}

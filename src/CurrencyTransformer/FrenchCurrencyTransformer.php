<?php

namespace WordifyNumber\CurrencyTransformer;

use WordifyNumber\Words\Words;

class FrenchCurrencyTransformer implements CurrencyTransformer
{
    public function toWords(int $number, string $currency): string
    {
        $converter = new Words();

        return $converter->transformToCurrency($number, $currency, 'fr');
    }
}

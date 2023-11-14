<?php

namespace WordifyNumber\CurrencyTransformer;

use WordifyNumber\Exception\WordifyNumberException;

interface CurrencyTransformer
{
    /**
     * @throws WordifyNumberException
     */
    public function toWords(int $number, string $currency): string;
}

<?php

namespace WordifyNumber\NumberTransformer;

use WordifyNumber\Exception\WordifyNumberException;

interface NumberTransformer
{
    /**
     * @throws WordifyNumberException
     */
    public function toWords(int $number): string;
}

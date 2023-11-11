<?php

namespace WordifyNumber\Words;

use WordifyNumber\Exception\InvalidArgumentException;
use WordifyNumber\Language\French\FrenchDictionnary;

class Words
{
    const EXPONENT_STEP = 3;
    private function splitNumber(int $number): array
    {
        // Cette méthode prend un nombre, 
        // le formate en tant que chaîne avec des espaces pour les milliers,
        // puis le divise en un tableau d'entiers.
        return array_map('intval', explode(' ', number_format($number, 0, '', ' ')));
    }

    private function getExponents(array $splitNumber): array
    {
        $length = count($splitNumber);
        $exponents = [];

        for ($i = 1; $i <= $length; $i++) {
            $curentExponent = ($i - 1) * self::EXPONENT_STEP;
            $exponents[] = $curentExponent;
        }

        return array_reverse($exponents);
    }

    public function getExponentsMappedToSplitNumber(int $number): array
    {
        $splitNumber = $this->splitNumber($number);
        $exponents = $this->getExponents($splitNumber);

        return array_combine($exponents, $splitNumber) ?: [];
    }
}

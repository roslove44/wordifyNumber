<?php

namespace WordifyNumber\Words;

use WordifyNumber\Exception\InvalidArgumentException;
use WordifyNumber\Language\French\FrenchDictionnary;

class Words
{
    public function splitNumber(int $number): array
    {
        // Cette méthode prend un nombre, 
        // le formate en tant que chaîne avec des espaces pour les milliers,
        // puis le divise en un tableau d'entiers.
        return array_map('intval', explode(' ', number_format($number, 0, '', ' ')));
    }

    public function getExponents(array $splitNumber)
    {
        $length = count($splitNumber);
        $exponents = [];
        for ($i = 1; $i <= $length; $i++) {
            $curentExponent = ($i - 1) * 3;
            $exponents[] = $curentExponent;
        }

        return $exponents;
    }
}

<?php

namespace WordifyNumber\Words\Locale;

use WordifyNumber\Language\French\FrenchDictionnary;

class Fr
{
    private static function getWordForDigit($digit)
    {
        $wordForDigit = FrenchDictionnary::$digits[$digit];

        return $wordForDigit;
    }

    private static function getWordForTeen($teen)
    {
        $wordForTen = FrenchDictionnary::$teens[$teen];

        return $wordForTen;
    }

    private static function getWordForTen($ten)
    {
        $wordForTen = FrenchDictionnary::$tens[$ten];

        return $wordForTen;
    }

    private static function getWordSeparator()
    {
        return FrenchDictionnary::$wordSeparator;
    }

    private static function getPluralSuffix()
    {
        return FrenchDictionnary::$pluralSuffix;
    }

    private function splitNumber($number)
    {
        // Cette méthode prend un nombre, le formate en tant que chaîne avec des espaces pour les milliers, puis le divise en un tableau d'entiers.
        return array_map('intval', explode(' ', number_format($number, 0, '', ' ')));
    }

    private function showDigitsGroup($num, $last = false)
    {
        //limite 999.999
        $result = '';

        $ones = $num % 10;
        $tens = (int) ($num % 100 / 10);
        $hundreds = (int) ($num % 1000 / 100);

        if ($hundreds) {
            if ($hundreds > 1) {
                $result .= self::getWordForDigit($hundreds) . self::getWordSeparator() . self::getWordForTen(100);

                if ($last && !$ones && !$tens) {
                    $result .= self::getPluralSuffix();
                }
            } else {
                $result .= self::getWordForTen(100);
            }

            $result .= self::getWordSeparator();
        }
    }
}

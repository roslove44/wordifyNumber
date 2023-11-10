<?php

namespace WordifyNumber\Words\Locale;

use WordifyNumber\Exception\InvalidArgumentException;
use WordifyNumber\Language\French\FrenchDictionnary;

class Fr
{
    private const MAX_DIGIT_FOR_TEEN = 19;
    private const MAX_DIGIT_FOR_DIGITS = 9;

    private function splitNumber(int $number): array
    {
        // Cette méthode prend un nombre, 
        // le formate en tant que chaîne avec des espaces pour les milliers,
        // puis le divise en un tableau d'entiers.
        return array_map('intval', explode(' ', number_format($number, 0, '', ' ')));
    }

    public function wordsForThreeDigitGroup(int $number): string
    {
        $result = "";

        // limite de caractère acceptable : 3
        if (strlen($number) > 3) {
            throw new InvalidArgumentException($number, 3, __FUNCTION__);
        }

        if ($number === 0) {
            return $result = FrenchDictionnary::$zero;
        }

        if ($number <= self::MAX_DIGIT_FOR_TEEN) {
            if ($number <= self::MAX_DIGIT_FOR_DIGITS) {
                return $result .= FrenchDictionnary::$digits[$number];
            } elseif ($number >= (self::MAX_DIGIT_FOR_DIGITS + 2)) {
                return  $result .= FrenchDictionnary::$teens[$number];
            }
        }

        $stringNumber = str_pad(strval($number), 3, '0', STR_PAD_LEFT);

        $hundred = (int) $stringNumber[0];
        $ten = (int) $stringNumber[1];
        $unit = (int) $stringNumber[2];

        $result .= $this->proccessHundred($hundred);
        $result .= $this->proccessTensAndUnits($ten, $unit);

        return trim($result);
    }

    private function proccessHundred(int $hundred): string
    {
        $hundredToWords = '';
        if ($hundred) {
            if ($hundred === 1) {
                $hundredToWords .= FrenchDictionnary::$tens[100];
            } else {
                $hundredToWords .= FrenchDictionnary::$digits[$hundred] . FrenchDictionnary::$wordSeparator . FrenchDictionnary::$tens[100] . FrenchDictionnary::$pluralSuffix;
            }
        }

        return $hundredToWords;
    }

    private function proccessTensAndUnits($ten, $unit): string
    {
        $tenAndUnitsToWords = '';
        if ($ten) {
            if ($unit !== 0) {
                if ($ten === 1 && $unit >= 1) {
                    $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . FrenchDictionnary::$teens[$ten . $unit];
                } elseif ($ten > 1 && $ten !== 7 && $ten !== 9) {
                    $tenWords = ($ten === 8) ? substr(FrenchDictionnary::$tens[$ten * 10], 0, -1) : FrenchDictionnary::$tens[$ten * 10];
                    if ($unit === 1) {
                        $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . $tenWords .
                            FrenchDictionnary::$dash . FrenchDictionnary::$and . FrenchDictionnary::$dash .
                            FrenchDictionnary::$digits[$unit];
                    } else {
                        $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . $tenWords .
                            FrenchDictionnary::$dash .
                            FrenchDictionnary::$digits[$unit];
                    }
                } elseif ($ten === 7 || $ten === 9) {
                    $pred = ($ten === 9) ? substr(FrenchDictionnary::$tens[($ten - 1) * 10], 0, -1) : FrenchDictionnary::$tens[($ten - 1) * 10];
                    if ($unit === 1) {
                        $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . $pred .
                            FrenchDictionnary::$dash . FrenchDictionnary::$and . FrenchDictionnary::$dash .
                            FrenchDictionnary::$teens[10 + $unit];
                    } elseif ($unit > 1) {
                        $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . $pred .
                            FrenchDictionnary::$dash . FrenchDictionnary::$teens[10 + $unit];
                    }
                }
            } else {
                $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . FrenchDictionnary::$tens[$ten * 10];
            }
        } elseif ($unit) {
            $tenAndUnitsToWords .= FrenchDictionnary::$wordSeparator . FrenchDictionnary::$digits[$unit];
        }
        return $tenAndUnitsToWords;
    }
}

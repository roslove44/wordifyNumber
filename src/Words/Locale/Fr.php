<?php

namespace WordifyNumber\Words\Locale;

use WordifyNumber\Exception\InvalidArgumentException;
use WordifyNumber\Language\French\FrenchDictionnary;
use WordifyNumber\Words\Words;

class Fr extends Words
{
    private const MAX_DIGIT_FOR_TEEN = 19;
    private const MAX_DIGIT_FOR_DIGITS = 9;

    public function toWords(int $number)
    {
        $result = '';
        $exponentsWithSplitNumber = $this->getExponentsMappedToSplitNumber($number);
        $length = count($exponentsWithSplitNumber);
        if ($length <= 1) {
            return $result = $this->wordsForThreeDigitGroup($exponentsWithSplitNumber[0], true);
        }

        foreach ($exponentsWithSplitNumber as $exponent => $splitNumber) {
            if ($exponent < 3) {
                $result .= $this->wordsForThreeDigitGroup($splitNumber);
            } else {
                if ($exponent === 3) {
                    if ($splitNumber === 1) {
                        $result .= $this->wordsForExponent($exponent) . FrenchDictionnary::$wordSeparator;
                    } elseif ($splitNumber > 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionnary::$wordSeparator .
                            $this->wordsForExponent($exponent) . FrenchDictionnary::$wordSeparator;
                    }
                } elseif ($exponent > 3) {
                    if ($splitNumber === 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionnary::$wordSeparator . $this->wordsForExponent($exponent) . FrenchDictionnary::$wordSeparator;
                    } elseif ($splitNumber > 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionnary::$wordSeparator .
                            $this->wordsForExponent($exponent) . FrenchDictionnary::$pluralSuffix
                            . FrenchDictionnary::$wordSeparator;
                    }
                }
            }
        }
        return $result;
    }

    private function wordsForExponent(int $exponent): string
    {
        return FrenchDictionnary::$exponents[$exponent];
    }

    private function wordsForThreeDigitGroup(int $number, $alone = false, $last = false): string
    {
        $result = "";

        // limite de caractère acceptable : 3
        if (strlen($number) > 3) {
            throw new InvalidArgumentException($number, 3, __FUNCTION__);
        }

        if ($number === 0 && $alone) {
            return $result = FrenchDictionnary::$zero;
        }

        if ($number <= self::MAX_DIGIT_FOR_TEEN) {
            if ($number <= self::MAX_DIGIT_FOR_DIGITS && $number !== 0) {
                return $result .= FrenchDictionnary::$digits[$number];
            } elseif ($number >= (self::MAX_DIGIT_FOR_DIGITS + 2)) {
                return  $result .= FrenchDictionnary::$teens[$number];
            }
        }

        $stringNumber = str_pad(strval($number), 3, '0', STR_PAD_LEFT);

        $hundred = (int) $stringNumber[0];
        $ten = (int) $stringNumber[1];
        $unit = (int) $stringNumber[2];

        if (!$ten && !$unit) {
            $last = true;
        }

        $result .= $this->proccessHundred($hundred, $last);
        $result .= $this->proccessTensAndUnits($ten, $unit);

        return trim($result);
    }

    private function proccessHundred(int $hundred, $last = false): string
    {
        $hundredToWords = '';
        if ($hundred) {
            if ($hundred === 1) {
                $hundredToWords .= FrenchDictionnary::$tens[100];
            } elseif ($hundred > 1 && $last) {
                $hundredToWords .= FrenchDictionnary::$digits[$hundred] . FrenchDictionnary::$wordSeparator . FrenchDictionnary::$tens[100] . FrenchDictionnary::$pluralSuffix;
            } elseif ($hundred > 1 && !$last) {
                $hundredToWords .= FrenchDictionnary::$digits[$hundred] . FrenchDictionnary::$wordSeparator . FrenchDictionnary::$tens[100];
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

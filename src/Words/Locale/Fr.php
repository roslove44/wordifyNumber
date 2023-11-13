<?php

namespace WordifyNumber\Words\Locale;

use WordifyNumber\Exception\InvalidArgumentException;
use WordifyNumber\Dictionary\Language\French\FrenchDictionary;
use WordifyNumber\Words\Words;

class Fr extends Words
{
    private const MAX_DIGIT_FOR_TEEN = 19;
    private const MAX_DIGIT_FOR_DIGITS = 9;

    private function wordsForExponent(int $exponent): string
    {
        return FrenchDictionary::$exponents[$exponent];
    }

    private function wordsForThreeDigitGroup(int $number, $alone = false, $last = false): string
    {
        $result = "";

        // limite de caractère acceptable : 3
        if (strlen($number) > 3) {
            throw new InvalidArgumentException($number, 3, __FUNCTION__);
        }

        if ($number === 0 && $alone) {
            return $result = FrenchDictionary::$zero;
        }

        if ($number <= self::MAX_DIGIT_FOR_TEEN) {
            if ($number <= self::MAX_DIGIT_FOR_DIGITS && $number !== 0) {
                return $result .= FrenchDictionary::$digits[$number];
            } elseif ($number >= (self::MAX_DIGIT_FOR_DIGITS + 2)) {
                return  $result .= FrenchDictionary::$teens[$number];
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

    private function proccessHundred(int $hundred, $last): string
    {
        $hundredToWords = '';
        if ($hundred) {
            if ($hundred === 1) {
                $hundredToWords .= FrenchDictionary::$tens[100];
            } elseif ($hundred > 1 && $last) {
                $hundredToWords .= FrenchDictionary::$digits[$hundred] . FrenchDictionary::$wordSeparator . FrenchDictionary::$tens[100] . FrenchDictionary::$pluralSuffix;
            } elseif ($hundred > 1 && !$last) {
                $hundredToWords .= FrenchDictionary::$digits[$hundred] . FrenchDictionary::$wordSeparator . FrenchDictionary::$tens[100];
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
                    $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . FrenchDictionary::$teens[$ten . $unit];
                } elseif ($ten > 1 && $ten !== 7 && $ten !== 9) {
                    $tenWords = ($ten === 8) ? substr(FrenchDictionary::$tens[$ten * 10], 0, -1) : FrenchDictionary::$tens[$ten * 10];
                    if ($unit === 1) {
                        $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . $tenWords .
                            FrenchDictionary::$dash . FrenchDictionary::$and . FrenchDictionary::$dash .
                            FrenchDictionary::$digits[$unit];
                    } else {
                        $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . $tenWords .
                            FrenchDictionary::$dash .
                            FrenchDictionary::$digits[$unit];
                    }
                } elseif ($ten === 7 || $ten === 9) {
                    $pred = ($ten === 9) ? substr(FrenchDictionary::$tens[($ten - 1) * 10], 0, -1) : FrenchDictionary::$tens[($ten - 1) * 10];
                    if ($unit === 1) {
                        $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . $pred .
                            FrenchDictionary::$dash . FrenchDictionary::$and . FrenchDictionary::$dash .
                            FrenchDictionary::$teens[10 + $unit];
                    } elseif ($unit > 1) {
                        $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . $pred .
                            FrenchDictionary::$dash . FrenchDictionary::$teens[10 + $unit];
                    }
                }
            } else {
                $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . FrenchDictionary::$tens[$ten * 10];
            }
        } elseif ($unit) {
            $tenAndUnitsToWords .= FrenchDictionary::$wordSeparator . FrenchDictionary::$digits[$unit];
        }
        return $tenAndUnitsToWords;
    }

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
                        $result .= $this->wordsForExponent($exponent) . FrenchDictionary::$wordSeparator;
                    } elseif ($splitNumber > 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionary::$wordSeparator .
                            $this->wordsForExponent($exponent) . FrenchDictionary::$wordSeparator;
                    }
                } elseif ($exponent > 3) {
                    if ($splitNumber === 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionary::$wordSeparator . $this->wordsForExponent($exponent) . FrenchDictionary::$wordSeparator;
                    } elseif ($splitNumber > 1) {
                        $result .= $this->wordsForThreeDigitGroup($splitNumber) . FrenchDictionary::$wordSeparator .
                            $this->wordsForExponent($exponent) . FrenchDictionary::$pluralSuffix
                            . FrenchDictionary::$wordSeparator;
                    }
                }
            }
        }
        return $result;
    }
}

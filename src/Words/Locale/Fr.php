<?php

namespace WordifyNumber\Words\Locale;

use WordifyNumber\Language\French\FrenchDictionnary;

class Fr
{
    private function splitNumber($number)
    {
        // Cette méthode prend un nombre, le formate en tant que chaîne avec des espaces pour les milliers, puis le divise en un tableau d'entiers.
        return array_map('intval', explode(' ', number_format($number, 0, '', ' ')));
    }
}

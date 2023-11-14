<?php

namespace WordifyNumber\Words;

use WordifyNumber\Exception\WordifyNumberException;

class Words
{
    public function transformToWords(int $number, string $locale): string
    {
        $localeClassName = $this->resolveLocaleClassName($locale);
        $transformer = new $localeClassName();

        return trim($transformer->toWords($number));
    }

    public function transformToCurrency(int $number, string $currency, $locale): string
    {
        $localeClassName = $this->resolveLocaleClassName($locale);
        $transformer = new $localeClassName();

        return trim($transformer->toCurrency($number, $currency));
    }

    private function resolveLocaleClassName(string $locale): string
    {
        $normalizedLocale = implode('\\', array_map(
            static fn ($element) => ucfirst(strtolower($element)),
            explode('_', $locale)
        ));

        if (empty($normalizedLocale)) {
            throw new WordifyNumberException('Invalid locale string');
        }

        $class = 'WordifyNumber\\Words\\Locale\\' . $normalizedLocale;

        if (!class_exists($class)) {
            throw new WordifyNumberException(sprintf('Unable to load locale class for %s', $locale));
        }

        return $class;
    }
}

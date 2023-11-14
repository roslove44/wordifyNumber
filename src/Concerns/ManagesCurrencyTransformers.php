<?php

namespace WordifyNumber\Concerns;

use InvalidArgumentException;
use WordifyNumber\CurrencyTransformer\CurrencyTransformer;
use WordifyNumber\CurrencyTransformer as Transformer;


trait ManagesCurrencyTransformers
{
    private array $currencyTransformers = [
        'fr' => Transformer\FrenchCurrencyTransformer::class,
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function getCurrencyTransformer(string $language): CurrencyTransformer
    {
        if (!array_key_exists($language, $this->currencyTransformers)) {
            throw new InvalidArgumentException(sprintf(
                'Currency transformer for "%s" language is not implemented.',
                $language
            ));
        }

        return new $this->currencyTransformers[$language]();
    }

    public static function transformCurrency(int $number, string $currency = 'XOF', string $language = 'fr'): string
    {
        return (new static())->getCurrencyTransformer($language)->toWords($number, $currency);
    }
}

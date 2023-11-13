<?php

namespace WordifyNumber\Concerns;

use InvalidArgumentException;
use WordifyNumber\NumberTransformer\NumberTransformer;
use WordifyNumber\NumberTransformer as Transformer;


trait ManagesNumberTransformers
{
    private array $numberTransformers = [
        'fr' => Transformer\FrenchNumberTransformer::class,
    ];

    /**
     * @throws InvalidArgumentException
     */
    public function getNumberTransformer(string $language): NumberTransformer
    {
        if (!array_key_exists($language, $this->numberTransformers)) {
            throw new InvalidArgumentException(sprintf(
                'Number transformer for "%s" language is not implemented.',
                $language
            ));
        }

        return new $this->numberTransformers[$language]();
    }

    public static function transformNumber(string $language, int $number): string
    {
        return (new static())->getNumberTransformer($language)->toWords($number);
    }
}

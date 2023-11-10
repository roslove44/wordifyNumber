<?php

namespace WordifyNumber\Exception;

use Exception;

class InvalidArgumentException extends Exception
{
    private $number;

    public function __construct(int $number, int $limit, string $function)
    {
        $this->number = $number;
        $message = "'$number' dépasse la limite de chiffres requise : \"$limit\" pour la conversion $function.";
        parent::__construct($message);
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}

<?php

namespace NumberPronunciation\Pronouncer;

use NumberPronunciation\IntegerNumber;

class PronouncerFactory
{
    /**
     * @param string $base
     * @return PronouncerInterface
     */
    public static function create($base)
    {
        switch ($base) {
            case IntegerNumber::BASE_DECIMAL:
                return new DecimalPronouncer();
                break;
            case IntegerNumber::BASE_HEX:
                return new HexPronouncer();
            default:
                throw new \InvalidArgumentException(sprintf("Pronouncer not implemented for %s numbers.", $base));
        }
    }
}
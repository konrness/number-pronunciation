<?php

namespace NumberPronunciation\Pronouncer;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronunciation;

class HexPronouncer implements PronouncerInterface
{
    const SINGLE = [
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'a',
        11 => 'bee',
        12 => 'cee',
        13 => 'dee',
        14 => 'e',
        15 => 'eff',
    ];

    const TEEN = [
        16 => 'ten',
        17 => 'eleven',
        18 => 'twelve',
        19 => 'thirteen',
        20 => 'fourteen',
        21 => 'fifteen',
        22 => 'sixteen',
        23 => 'seventeen',
        24 => 'eighteen',
        25 => 'nineteen',
        26 => 'abteen',
        27 => 'bibteen',
        28 => 'cleventeen',
        29 => 'dibbleteen',
        30 => 'eggteen',
        31 => 'fleventeen',
    ];

    const TENS = [
        2 => 'twenty',
        3 => 'thirty',
        4 => 'forty',
        5 => 'fifty',
        6 => 'sixty',
        7 => 'seventy',
        8 => 'eighty',
        9 => 'ninety',
        10 => 'atta',
        11 => 'bibbity',
        12 => 'city',
        13 => 'dickety',
        14 => 'ebbity',
        15 => 'fleventy',
    ];

    /**
     * @see http://www.bzarg.com/p/how-to-pronounce-hexadecimal/
     * @param IntegerNumber $number
     * @return Pronunciation
     */
    public function pronounce(IntegerNumber $number)
    {
        $numberPart = $number->getValue();

        if (strlen($numberPart) > 6) {
            throw new \InvalidArgumentException("Only 3-byte hexadecimals can be pronounced.");
        }

        $outputParts = [];

        if ($numberPart === "0") {
            return self::SINGLE[$numberPart];
        }

        // negative
        if (! $number->isPositive()) {
            $outputParts[] = "negative";
        }

        $powerNames = [
            3 => "halfy",
            2 => "bitey",
            1 => "",
        ];

        foreach ($powerNames as $power => $powerName) {
            if (strlen($numberPart) < (($power * 2)-1)) {
                continue;
            }

            // retrieve big-endian byte part (2-characters), which could be only one character (nibble)
            if ($power == 1) {
                $bytePart = substr($numberPart, $power * -2);
            } else {
                $bytePart = substr($numberPart, $power * -2, $power * -2 + 2);
            }

            $outputParts[] = trim($this->pronounceByte($bytePart, false, $powerName));
        }

        // remove empty output parts to allow for halfy bitey's
        $outputParts = array_filter($outputParts, function($part){
            return (boolean) $part;
        });

        return trim(implode(" ", $outputParts));
    }

    /**
     * Pronounce pair of up to two hex digits
     * Example: 32 = thirty-two
     *
     * @param string $tuplet
     * @param boolean $pronounceZero
     * @return string
     */
    private function pronounceByte($tuplet, $pronounceZero, $magnitude = "")
    {
        $value = hexdec($tuplet);

        if ($magnitude) {
            $magnitude = " " . $magnitude;
        }

        switch (true) {
            case $value == 0:
                return $pronounceZero ? self::SINGLE[0] : "" . $magnitude;
            case $value < 16:
                return self::SINGLE[$value] . $magnitude;
            case $value < 32:
                return self::TEEN[$value] . $magnitude;
            case 0 == $value % 16:
                return self::TENS[floor($value / 16)] . $magnitude;
            default:
                return self::TENS[floor($value / 16)] . '-' . self::SINGLE[$value % 16] . $magnitude;

        }
    }

}
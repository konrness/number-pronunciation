<?php

namespace NumberPronunciation\Pronouncer;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronunciation;

class DecimalPronouncer implements PronouncerInterface
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
    ];

    const TEEN = [
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
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
    ];

    /**
     * @param IntegerNumber $number
     * @return Pronunciation
     */
    public function pronounce(IntegerNumber $number)
    {
        $numberPart = $number->getValue();
        $outputParts = [];

        if (strlen($numberPart) > 15) {
            throw new \InvalidArgumentException("Only 15-digit decimals can be pronounced.");
        }

        if ($numberPart === "0") {
            return self::SINGLE[$numberPart];
        }

        // negative
        if (! $number->isPositive()) {
            $outputParts[] = "negative";
        }

        $periodNames = [
            5 => "trillion",
            4 => "billion",
            3 => "million",
            2 => "thousand",
            1 => "",
        ];

        foreach ($periodNames as $period => $periodName) {
            if (strlen($numberPart) < (($period * 3)-2)) {
                continue;
            }

            // retrieve 3-character period, which could be less than 3 (e.g. 2 in 2000)
            if ($period == 1) {
                $periodPart = substr($numberPart, $period * -3);
            } else {
                $periodPart = substr($numberPart, $period * -3, $period * -3 + 3);
            }

            $outputParts[] = $this->pronounceTriplet($periodPart, $periodName);
        }

        // remove empty output parts
        $outputParts = array_filter($outputParts, function($part){
            return (boolean) $part;
        });

        return trim(implode(" ", $outputParts));
    }

    /**
     * Pronounce tuplet of three numbers
     * Example: 232 = two hundred thirty-two
     *
     * @param string $triplet
     * @return string
     */
    private function pronounceTriplet($triplet, $magnitude = "")
    {
        $value = (int) $triplet;

        switch (true) {
            case $value == 0:
                return $this->pronouncePair($triplet, false);
            case $value < 100:
                return $this->pronouncePair($triplet, true) . ($magnitude ? " " . $magnitude : "");
            case $value < 999:
                $out = self::SINGLE[floor($value / 100)] . " hundred";

                if ($tuplet = $this->pronouncePair(substr($triplet, 1), false)) {
                    $out .= " " . $tuplet;
                }
                return $out . ($magnitude ? " " . $magnitude : "");
        }
    }

    /**
     * Pronounce pair of two number
     * Example: 32 = thirty-two
     *
     * @param string $tuplet
     * @param boolean $pronounceZero
     * @return string
     */
    private function pronouncePair($tuplet, $pronounceZero)
    {
        $value = (int) $tuplet;

        switch (true) {
            case $value == 0:
                return $pronounceZero ? self::SINGLE[0] : "";
            case $value < 10:
                return self::SINGLE[$value];
            case $value < 20:
                return self::TEEN[$value];
            case 0 == $value % 10:
                return self::TENS[floor($value / 10)];
            default:
                return self::TENS[floor($value / 10)] . '-' . self::SINGLE[$value % 10];

        }
    }

}
<?php

namespace NumberPronunciation;

class NumberParser
{

    /**
     *
     * @see http://php.net/manual/en/language.types.integer.php
     *
     * @param string $input
     * @return \NumberPronunciation\IntegerNumber
     */
    public function parse($input)
    {
        $number = new IntegerNumber($input);

        if ('-' == substr($input, 0, 1)) {
            $input = substr($input, 1);
            $number->setValue($input);
            $number->setIsPositive(false);
        } else {
            if ('+' == substr($input, 0, 1)) {
                $input = substr($input, 1);
            }

            $number->setIsPositive(true);
            $number->setValue($input);
        }

        switch (true) {
            case preg_match('/^0[xX][0-9a-fA-F]+$/', $number->getValue()):
                $number->setValue(substr($number->getValue(), 2));
                $number->setPrefix("0x");
                $number->setBase(IntegerNumber::BASE_HEX);
                break;
            case preg_match('/^0[0-7]+$/', $number->getValue()):
                $number->setValue(substr($number->getValue(), 1));
                $number->setPrefix("0");
                $number->setBase(IntegerNumber::BASE_OCTAL);
                break;
            case preg_match('/^0b[01]+$/', $number->getValue()):
                $number->setValue(substr($number->getValue(), 2));
                $number->setPrefix("0b");
                $number->setBase(IntegerNumber::BASE_BINARY);
                break;
            case ("0" === $input):
            case preg_match('/^[1-9][0-9]*$/', $number->getValue()):
                $number->setPrefix("");
                $number->setBase(IntegerNumber::BASE_DECIMAL);
                break;
            default:
                throw new \InvalidArgumentException("Unable to parse number: invalid format");
        }

        return $number;
    }
}
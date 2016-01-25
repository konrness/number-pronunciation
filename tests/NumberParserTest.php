<?php

namespace NumberPronunciationTests;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\NumberParser;

class NumberParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider successProvider
     */
    public function testSuccessfulParse($input, $prefix, $base, $isPositive)
    {
        $parser = new NumberParser();
        $integer = $parser->parse($input);

        $this->assertEquals($base, $integer->getBase());
        $this->assertEquals($isPositive, $integer->isPositive());

        $this->assertInternalType("string", $integer->getValue());
        
        // strip prefix from input
        $value = substr($input, strlen($prefix));

        if ($isPositive) {
            $this->assertEquals($value, $integer->getValue());
        } else {
            $this->assertEquals(substr($value, 1), $integer->getValue());
        }
    }

    /**
     * @dataProvider failProvider
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unable to parse number: invalid format
     */
    public function testFailParse($input, $base, $isPositive)
    {
        $parser = new NumberParser();
        $input = $parser->parse($input);

        $this->fail("It was actually parsed as: " . $input->getBase());
    }


    public function successProvider()
    {
        return [
            // decimal
            ["1234",  "", IntegerNumber::BASE_DECIMAL, true],
            ["+1234",  "+", IntegerNumber::BASE_DECIMAL, true],
            ["-1234", "", IntegerNumber::BASE_DECIMAL, false],
            ["0",     "", IntegerNumber::BASE_DECIMAL, true],

            // hexadecimal
            ["0x1234",   "0x", IntegerNumber::BASE_HEX, true],
            ["+0x1234",   "+0x", IntegerNumber::BASE_HEX, true],
            ["-0x1234",  "0x", IntegerNumber::BASE_HEX, false],
            ["0x0",      "0x", IntegerNumber::BASE_HEX, true],
            ["0X1234",   "0x", IntegerNumber::BASE_HEX, true],
            ["0xABCDEF", "0x", IntegerNumber::BASE_HEX, true],

            // octal
            ["01234",    "0", IntegerNumber::BASE_OCTAL, true],
            ["+01234",    "+0", IntegerNumber::BASE_OCTAL, true],
            ["-01234",   "0", IntegerNumber::BASE_OCTAL, false],
            ["00",       "0", IntegerNumber::BASE_OCTAL, true],
            ["01234567", "0", IntegerNumber::BASE_OCTAL, true],

            // binary
            ["0b010101",  "0b", IntegerNumber::BASE_BINARY, true],
            ["+0b010101",  "+0b", IntegerNumber::BASE_BINARY, true],
            ["-0b010101", "0b", IntegerNumber::BASE_BINARY, false],
            ["0b0",       "0b", IntegerNumber::BASE_BINARY, true],
        ];
    }

    public function failProvider()
    {
        return [
            // decimal with floating point
            ["1234.12", IntegerNumber::BASE_DECIMAL, true],
            ["-1234.12", IntegerNumber::BASE_DECIMAL, false],
            ["0.0", IntegerNumber::BASE_DECIMAL, true],

            // hexadecimal with invalid ordinals
            ["0x1234567890ABCDEFG", IntegerNumber::BASE_HEX, true],
            ["-0x1234567890ABCDEFG", IntegerNumber::BASE_HEX, false],

            // octal with invalid ordinals
            ["012345678", IntegerNumber::BASE_OCTAL, true],
            ["-012345678", IntegerNumber::BASE_OCTAL, false],

            // binary with invalid ordinals
            ["0b012", IntegerNumber::BASE_BINARY, true],
            ["-0b012", IntegerNumber::BASE_BINARY, false],

        ];
    }

}

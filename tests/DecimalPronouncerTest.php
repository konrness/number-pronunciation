<?php

namespace NumberPronunciationTests;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronouncer\DecimalPronouncer;

class DecimalPronouncerTest extends \PHPUnit_Framework_TestCase
{

    public function testZero()
    {
        $number = new IntegerNumber("0", IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("zero", $pronunciation);
    }

    public function testNegativeZero()
    {
        $number = new IntegerNumber("0", IntegerNumber::BASE_DECIMAL);

        $number->isPositive(false);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("zero", $pronunciation);
    }

    public function testPronounceTwoDigit()
    {
        $number = new IntegerNumber("32", IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("thirty-two", $pronunciation);
    }

    public function testPronounceThreeDigit()
    {
        $number = new IntegerNumber("132", IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("one hundred thirty-two", $pronunciation);
    }

    public function testPronounceFourDigit()
    {
        $number = new IntegerNumber("1032", IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("one thousand thirty-two", $pronunciation);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only 15-digit decimals can be pronounced.
     */
    public function testExceedMaximumDigits()
    {
        $number = new IntegerNumber("1234567890123345", IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronouncer->pronounce($number);
    }

    /**
     * @dataProvider provider
     */
    public function testPronunciations($input, $expected)
    {
        $number = new IntegerNumber($input, IntegerNumber::BASE_DECIMAL);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals($expected, $pronunciation);
    }

    /**
     * @dataProvider provider
     */
    public function testNegativePronunciations($input, $expected)
    {
        $number = new IntegerNumber($input, IntegerNumber::BASE_DECIMAL);

        $number->setIsPositive(false);

        $pronouncer = new DecimalPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("negative " . $expected, $pronunciation);
    }

    public function provider()
    {
        return [
            ["5", "five"],
            ["10", "ten"],
            ["13", "thirteen"],

            ["100", "one hundred"],
            ["300", "three hundred"],
            ["102", "one hundred two"],
            ["117", "one hundred seventeen"],

            ["1000", "one thousand"],
            ["1050", "one thousand fifty"],
            ["1150", "one thousand one hundred fifty"],

            ["10000", "ten thousand"],
            ["10050", "ten thousand fifty"],
            ["10150", "ten thousand one hundred fifty"],

            ["100000", "one hundred thousand"],
            ["150000", "one hundred fifty thousand"],
            ["150105", "one hundred fifty thousand one hundred five"],
            ["150150", "one hundred fifty thousand one hundred fifty"],

            ["1000000", "one million"],
            ["1000050", "one million fifty"],
            ["1500000", "one million five hundred thousand"],
            ["10500500", "ten million five hundred thousand five hundred"],
            ["100500550", "one hundred million five hundred thousand five hundred fifty"],

            ["1034", "one thousand thirty-four"],
            ["1234", "one thousand two hundred thirty-four"],
            ["12345678", "twelve million three hundred forty-five thousand six hundred seventy-eight"],

            ["1234567890123", "one trillion two hundred thirty-four billion five hundred sixty-seven million eight hundred ninety thousand one hundred twenty-three"]

        ];
    }

}

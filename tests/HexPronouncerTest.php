<?php

namespace NumberPronunciationTests;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronouncer\DecimalPronouncer;
use NumberPronunciation\Pronouncer\HexPronouncer;

class HexPronouncerTest extends \PHPUnit_Framework_TestCase
{

    public function testZero()
    {
        $number = new IntegerNumber("0", IntegerNumber::BASE_HEX);

        $pronouncer = new HexPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("zero", $pronunciation);
    }

    public function testNegativeZero()
    {
        $number = new IntegerNumber("0", IntegerNumber::BASE_HEX);

        $pronouncer = new HexPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("zero", $pronunciation);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only 3-byte hexadecimals can be pronounced.
     */
    public function testOverflow()
    {
        $number = new IntegerNumber("A000000", IntegerNumber::BASE_HEX);

        $pronouncer = new HexPronouncer();
        $pronouncer->pronounce($number);
    }

    /**
     * @dataProvider provider
     */
    public function testPronunciations($input, $expected)
    {
        $number = new IntegerNumber($input, IntegerNumber::BASE_HEX);

        $pronouncer = new HexPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals($expected, $pronunciation);
    }

    /**
     * @dataProvider provider
     */
    public function testNegativePronunciations($input, $expected)
    {
        $number = new IntegerNumber($input, IntegerNumber::BASE_HEX);

        $number->setIsPositive(false);

        $pronouncer = new HexPronouncer();
        $pronunciation = $pronouncer->pronounce($number);

        $this->assertEquals("negative " . $expected, $pronunciation);
    }

    public function provider()
    {
        return [
            ["1", "one"],
            ["5", "five"],
            ["9", "nine"],
            ["10", "ten"],
            ["13", "thirteen"],
            ["19", "nineteen"],

            ["1A", "abteen"],
            ["1B", "bibteen"],
            ["1C", "cleventeen"],
            ["1D", "dibbleteen"],
            ["1E", "eggteen"],
            ["1F", "fleventeen"],

            ["F5", "fleventy-five"],
            ["B3", "bibbity-three"],
            ["E4", "ebbity-four"],

            ["1F5", "one bitey fleventy-five"],
            ["AB3", "a bitey bibbity-three"],
            ["FE4", "eff bitey ebbity-four"],

            ["BBBB", "bibbity-bee bitey bibbity-bee"],
            ["A0C9", "atta bitey city-nine"],
            ["ABCD", "atta-bee bitey city-dee"],

            ["DAF1", "dickety-a bitey fleventy-one"],
            ["E137", "ebbity-one bitey thirty-seven"],
            ["A0C9", "atta bitey city-nine"],
            ["BBBB", "bibbity-bee bitey bibbity-bee"],

            ["1000", "ten bitey"],
            ["1050", "ten bitey fifty"],
            ["1150", "eleven bitey fifty"],
            ["1500", "fifteen bitey"],
            ["15D0", "fifteen bitey dickety"],
            ["15D1", "fifteen bitey dickety-one"],

            ["FDAF1", "eff halfy dickety-a bitey fleventy-one"],
            ["3E137", "three halfy ebbity-one bitey thirty-seven"],
            ["CA0C9", "cee halfy atta bitey city-nine"],
            ["BBBBB", "bee halfy bibbity-bee bitey bibbity-bee"],

            ["101000", "ten halfy ten bitey"],
            ["111150", "eleven halfy eleven bitey fifty"],

            ["F1DAF1", "fleventy-one halfy dickety-a bitey fleventy-one"],
            ["37E137", "thirty-seven halfy ebbity-one bitey thirty-seven"],
            ["C9A0C9", "city-nine halfy atta bitey city-nine"],
            ["BBBBBB", "bibbity-bee halfy bibbity-bee bitey bibbity-bee"],

            ["AB0000", "atta-bee halfy bitey"]

        ];
    }

}

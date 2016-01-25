<?php
/**
 * Created by PhpStorm.
 * User: kness
 * Date: 1/25/16
 * Time: 12:27 PM
 */

namespace NumberPronunciationTests;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronouncer\DecimalPronouncer;
use NumberPronunciation\Pronouncer\HexPronouncer;
use NumberPronunciation\Pronouncer\PronouncerFactory;

class PronouncerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateDecimal()
    {
        $pronouncer = PronouncerFactory::create(IntegerNumber::BASE_DECIMAL);

        $this->assertInstanceOf(DecimalPronouncer::class, $pronouncer);
    }

    public function testCreateHex()
    {
        $pronouncer = PronouncerFactory::create(IntegerNumber::BASE_HEX);

        $this->assertInstanceOf(HexPronouncer::class, $pronouncer);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Pronouncer not implemented for binary numbers.
     */
    public function testCreateError()
    {
        $pronouncer = PronouncerFactory::create(IntegerNumber::BASE_BINARY);
    }
}

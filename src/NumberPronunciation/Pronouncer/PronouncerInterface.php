<?php
/**
 * Created by PhpStorm.
 * User: kness
 * Date: 1/18/16
 * Time: 5:58 PM
 */

namespace NumberPronunciation\Pronouncer;


use NumberPronunciation\IntegerNumber;
use NumberPronunciation\Pronunciation;

interface PronouncerInterface
{

    /**
     * @param IntegerNumber $number
     * @return Pronunciation
     */
    public function pronounce(IntegerNumber $number);

}
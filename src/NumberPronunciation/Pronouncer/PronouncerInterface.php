<?php
/**
 * Created by PhpStorm.
 * User: kness
 * Date: 1/18/16
 * Time: 5:58 PM
 */

namespace NumberPronunciation\Pronouncer;


use NumberPronunciation\IntegerNumber;

interface PronouncerInterface
{

    /**
     * @param IntegerNumber $number
     * @return string
     */
    public function pronounce(IntegerNumber $number);

}
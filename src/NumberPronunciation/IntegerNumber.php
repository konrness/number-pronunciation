<?php

namespace NumberPronunciation;


class IntegerNumber
{
    const BASE_HEX = 'hex';
    const BASE_BINARY = 'binary';
    const BASE_OCTAL = 'octal';
    const BASE_DECIMAL = 'decimal';
    const BASE_DECIMAL_EXPONENTIAL = 'decimal_exponential';

    /**
     * The base of the number.
     *
     * @var string
     */
    private $base;

    /**
     * Whether the number is positive or negative
     *
     * @var bool
     */
    private $isPositive = true;

    /**
     * The absolute value of the number, represented in the base.
     *
     * @var string
     */
    private $value;

    /**
     * The base prefix (0x, 0, 0b, etc.)
     *
     * @var string
     */
    private $prefix;

    /**
     * Number constructor.
     * @param string $value
     * @param string $base
     * @param boolean $isPositive
     */
    public function __construct($value, $base = null, $isPositive = true, $prefix = "")
    {
        $this->base       = $base;
        $this->value      = $value;
        $this->isPositive = $isPositive;
        $this->prefix     = $prefix;
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param string $base
     */
    public function setBase($base)
    {
        $this->base = $base;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return $this->isPositive;
    }

    /**
     * @param boolean $isPositive
     */
    public function setIsPositive($isPositive)
    {
        $this->isPositive = $isPositive;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }



}
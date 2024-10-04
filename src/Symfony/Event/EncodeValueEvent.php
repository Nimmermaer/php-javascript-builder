<?php

/**
 * This file is part of the netzmacht/php-javascript-builder class
 *
 * @package    php-javascript-builder
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2022 netzmacht creative David Molineus
 * @license    LGPL 3.0-or-later
 * @filesource
 */
namespace Netzmacht\JavascriptBuilder\Symfony\Event;

use Netzmacht\JavascriptBuilder\Encoder;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class EncodeValueEvent is emitted when a value is being encoded.
 *
 * @package Netzmacht\JavascriptBuilder\Event
 */
class EncodeValueEvent extends GenericEvent
{
    const NAME = 'javascript-builder.encode-value';

    /**
     * The value.
     *
     * @var mixed
     */
    private $value;

    /**
     * The created result.
     *
     * @var array
     */
    private $lines = array();

    /**
     * Successful state.
     *
     * @var bool
     */
    private $successful = false;

    /**
     * The encoder.
     *
     * @var Encoder
     */
    private $encoder;

    /**
     * Json_encode flags.
     *
     * @var null|int
     */
    private $flags;

    /**
     * Construct.
     *
     * @param Encoder $encoder        The encoder.
     * @param mixed   $value          The value.
     * @param int     $jsonEncodeFlag The json_encode flags.
     */
    public function __construct(Encoder $encoder, $value, $jsonEncodeFlag = null)
    {
        $this->value   = $value;
        $this->encoder = $encoder;
        $this->flags   = $jsonEncodeFlag;
    }

    /**
     * Get the encoder.
     *
     * @return Encoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * Get the value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the result.
     *
     * @return array
     */
    public function getResult()
    {
        return implode("\n", $this->lines);
    }

    /**
     * Add a result line.
     *
     * @param mixed $result     The encoded javascript result.
     * @param bool  $successful Mark result as successful.
     *
     * @return $this
     */
    public function addLine($result, $successful = true)
    {
        $this->lines[] = $result;

        if ($successful) {
            $this->successful = true;
        }

        return $this;
    }

    /**
     * Check if encoding was successful.
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * Mark encoded value as successful no matter if any content was set.
     *
     * @return $this
     */
    public function setSuccessful()
    {
        $this->successful = true;

        return $this;
    }

    /**
     * Get the json flags.
     *
     * @return int|null
     */
    public function getJsonFlags()
    {
        return $this->flags;
    }
}

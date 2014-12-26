<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Javascript\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class GetReferenceEvent is emitted when a string reference of an variable is requested.
 *
 * @package Netzmacht\Javascript\Event
 */
class GetReferenceEvent extends Event
{
    const NAME = 'javascript-builder.get-reference';

    /**
     * The object.
     *
     * @var mixed
     */
    private $object;

    /**
     * The reference.
     *
     * @var string
     */
    private $reference;

    /**
     * Construct.
     *
     * @param $object
     */
    function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Get the reference object.
     *
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Get the reference.
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the object reference name.
     *
     * @param string $reference The reference name,
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }
}

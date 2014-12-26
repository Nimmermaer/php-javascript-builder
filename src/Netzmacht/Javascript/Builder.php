<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Javascript;

use Netzmacht\Javascript\Event\BuildValueEvent;
use Netzmacht\Javascript\Event\GetReferenceEvent;
use Netzmacht\Javascript\Exception\BuildValueFailed;
use Netzmacht\Javascript\Exception\GetReferenceFailed;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Builder provides methods to build javascript for several input types.
 *
 * @package Netzmacht\Javascript
 */
class Builder
{
    const VALUE_DEFINE              = 0;
    const VALUE_REFERENCE_PREFERRED = 1;
    const VALUE_REFERENCE_REQUIRED  = 2;

    /**
     * The event dispatcher.
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Construct.
     *
     * @param EventDispatcherInterface $dispatcher The event dispatcher.
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Build javascript value for a given input.
     *
     * @param mixed $value      The given value.
     * @param int   $referenced Value reference state.
     *
     * @return string
     *
     * @throws BuildValueFailed If no value could be built.
     */
    public function buildValue($value, $referenced = self::VALUE_DEFINE)
    {
        $event = new BuildValueEvent($this, $value, $referenced);
        $this->dispatcher->dispatch($event::NAME, $event);

        if ($event->isSuccessful()) {
            return $event->getResult();
        }

        throw new BuildValueFailed($value, $referenced);
    }

    /**
     * Build a list of arguments.
     *
     * @param array $arguments List of arguments.
     *
     * @return string
     */
    public function buildArguments(array $arguments)
    {
        $build = array();

        foreach ($arguments as $argument) {
            $build[] = $this->buildValue($argument, static::VALUE_REFERENCE_REQUIRED);
        }

        return implode(', ', $build);
    }

    /**
     * Build reference of given variable/object.
     *
     * @param object $object Build reference for an object.
     *
     * @return string
     *
     * @throws GetReferenceFailed If no reference was created.
     */
    public function buildReference($object)
    {
        $event = new GetReferenceEvent($object);
        $this->dispatcher->dispatch($event::NAME, $event);

        if ($event->getReference()) {
            return $event->getReference();
        }

        throw new GetReferenceFailed($object);
    }
}

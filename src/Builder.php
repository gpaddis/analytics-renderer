<?php

namespace Gpaddis\AnalyticsRenderer;

/**
 * @package Gpaddis\AnalyticsRenderer
 */
class Builder
{
    protected function __construct()
    {
    }

    /**
     * Return an instance of the object type or throw an exception.
     *
     * @param string $objectType
     * @return mixed
     */
    public static function make($objectType)
    {
        $fullClassName = "\Gpaddis\AnalyticsRenderer\\" . $objectType;
        if (class_exists($fullClassName)) {
            return new $fullClassName();
        }

        throw new \InvalidArgumentException("Cannot build the non-existing object $objectType.");
    }
}

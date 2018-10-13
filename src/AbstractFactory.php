<?php

namespace Gpaddis\AnalyticsRenderer;

abstract class AbstractFactory
{
    protected static $namespace = 'Gpaddis\AnalyticsRenderer';

    protected static $classAliases = [];

    /**
     * Return an instance of the (aliased) object type or throw an exception.
     *
     * @param string $objectType
     * @return mixed
     */
    public static function make($objectType)
    {
        if (array_key_exists($objectType, static::$classAliases)) {
            $objectType = static::$classAliases[$objectType];
        }

        $fullClassName = static::$namespace . '\\' . $objectType;
        if (class_exists($fullClassName)) {
            return new $fullClassName();
        }

        throw new \InvalidArgumentException(
            "Cannot create the non-existing object $objectType."
        );
    }
}

<?php

namespace Gpaddis\AnalyticsRenderer;

/**
 * @package Gpaddis\AnalyticsRenderer
 */
class Builder
{
    protected static $objectAliases = [
        'click' => 'EnhancedEcommerce\Activity\Click',
        'detail' => 'EnhancedEcommerce\Activity\Detail',
        'impressions' => 'EnhancedEcommerce\Activity\Impressions',
        'purchase' => 'EnhancedEcommerce\Activity\Purchase',

        'actionFieldObject' => 'EnhancedEcommerce\FieldObject\Action',
        'productFieldObject' => 'EnhancedEcommerce\FieldObject\Product'
    ];

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
        if (array_key_exists($objectType, self::$objectAliases)) {
            $objectType = self::$objectAliases[$objectType];
        }

        $fullClassName = "\Gpaddis\AnalyticsRenderer\\" . $objectType;
        if (class_exists($fullClassName)) {
            return new $fullClassName();
        }

        throw new \InvalidArgumentException(
            "Cannot build the non-existing object $objectType."
        );
    }
}

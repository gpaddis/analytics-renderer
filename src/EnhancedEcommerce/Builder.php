<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce;

use Gpaddis\AnalyticsRenderer\AbstractBuilder;

class Builder extends AbstractBuilder
{
    protected static $namespace = 'Gpaddis\AnalyticsRenderer\EnhancedEcommerce';

    protected static $classAliases = [
        // Activity
        'checkout' => 'Activity\Checkout',
        'click' => 'Activity\Click',
        'detail' => 'Activity\Detail',
        'impressions' => 'Activity\Impressions',
        'purchase' => 'Activity\Purchase',

        // FieldObject
        'actionFieldObject' => 'FieldObject\Action',
        'productFieldObject' => 'FieldObject\Product'
    ];
}

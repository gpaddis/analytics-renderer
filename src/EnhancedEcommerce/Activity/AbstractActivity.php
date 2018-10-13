<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Activity;

use Gpaddis\AnalyticsRenderer\AbstractObject;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\AddProducts;

abstract class AbstractActivity extends AbstractObject
{
    use AddProducts;

    protected $productArrayKey = 'products';
}

<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Activity;

use Gpaddis\AnalyticsRenderer\AbstractObject;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\AddProducts;

class Detail extends AbstractObject
{
    use AddProducts;

    protected $productArrayKey = 'products';
}

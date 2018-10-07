<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce;

use Gpaddis\AnalyticsRenderer\AbstractObject;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\FieldObject\Product;

class Impressions extends AbstractObject
{
    public function addProduct(Product $product)
    {
        $this->add('impressions', $product);
        return $this;
    }
}

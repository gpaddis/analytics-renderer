<?php

namespace Gpaddis\AnalyticsRenderer\EnhancedEcommerce;

use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\FieldObject\Product;

/**
 * This trait provides the necessary methods to add one or more products
 * to an object. It requires the property $productArrayKey to be
 * specified in the class that uses the trait.
 */
trait AddProducts
{
    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product)
    {
        $this->checkIfProductArrayKeyIsSet();

        $this->add($this->productArrayKey, $product);
        return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function checkIfProductArrayKeyIsSet()
    {
        if (!isset($this->productArrayKey)) {
            throw new \Exception(sprintf(
                "You must specify a productArrayKey in the class %s in order to use the trait AddProducts.",
                self::class
            ));
        }
    }

    /**
     * @param array $arrayOfProducts
     * @return $this
     */
    public function addProducts($arrayOfProducts)
    {
        foreach ($arrayOfProducts as $product) {
            $this->addProduct($product);
        }

        return $this;
    }
}

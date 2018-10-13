<?php

namespace Tests\EnhancedEcommerce;

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Builder;

class BuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_an_instance_of_the_expected_class()
    {
        $productFieldObject = Builder::make('FieldObject\Product');
        $aliasedProductFieldObject = Builder::make('productFieldObject');

        $expectedType = 'Gpaddis\AnalyticsRenderer\EnhancedEcommerce\FieldObject\Product';

        $this->assertInstanceOf($expectedType, $productFieldObject);
        $this->assertInstanceOf($expectedType, $aliasedProductFieldObject);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_an_exception_on_a_nonexisting_object_type()
    {
        Builder::make('some\nonexistent\class');
    }
}

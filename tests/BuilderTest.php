<?php

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\Builder;

class BuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_a_productFieldObject()
    {
        $productFieldObject = Builder::make('EnhancedEcommerce\FieldObject\Product');
        $this->assertInstanceOf('Gpaddis\AnalyticsRenderer\EnhancedEcommerce\FieldObject\Product', $productFieldObject);
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

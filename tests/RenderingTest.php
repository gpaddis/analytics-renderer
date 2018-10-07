<?php

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\Builder;

class RenderingTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_a_multidimensional_object_to_json()
    {
        $product = Builder::make('productFieldObject')
            ->set('name', 'Test Product');

        $object = Builder::make('impressions')
            ->set('field1', 'value1')
            ->addProduct($product);

        $json = $object->asJson();
        $minifiedJson = $object->asJson();

        $this->assertJson($json);
        $this->assertJson($minifiedJson);
        $this->assertContains('Test Product', $json);
        $this->assertContains('value1', $minifiedJson);
    }

    /**
     * @test
     */
    public function it_renders_an_object_to_json_with_variables()
    {
        $product = Builder::make('productFieldObject')
            ->set('name', 'Test Product')
            ->setVariable('var1', 'variable1')
            ->setVariable('var2', 'variable2');

        $object = Builder::make('impressions')
            ->set('field1', 'value1')
            ->addProduct($product)
            ->setVariable('var3', 'variable3')
            ->setVariable('var4', 'variable4');

        $json = $object->asJson();

        $this->assertContains('"var1": variable1', $json);
        $this->assertContains('"var2": variable2', $json);
        $this->assertContains('"var3": variable3', $json);
        $this->assertContains('"var4": variable4', $json);
    }
}

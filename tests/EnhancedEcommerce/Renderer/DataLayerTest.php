<?php

namespace Tests\EnhancedEcommerce\Renderer;

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Renderer\DataLayer;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Factory;

class DataLayerTest extends TestCase
{
    public function setUp()
    {
        $this->renderer = new DataLayer();
        $this->product = Factory::make('productFieldObject')
            ->set('id', '12345')
            ->set('name', 'Example Product');
    }

    /**
     * @test
     * @dataProvider checkout
     */
    public function it_renders_a_checkout_object($expected)
    {
        $actionFieldObject = Factory::make('actionFieldObject')
            ->set('step', 1)
            ->set('option', 'Visa');

        $checkout = Factory::make('checkout')
            ->set('actionField', $actionFieldObject)
            ->addProduct($this->product);

        $this->assertIsRenderedCorrectly($expected, $checkout);
    }

    /**
     * @test
     * @dataProvider detail
     */
    public function it_renders_a_detail_object($expected)
    {
        $actionFieldObject = Factory::make('actionFieldObject')
            ->set('list', 'Apparel Gallery');

        $detail = Factory::make('detail')
            ->set('actionField', $actionFieldObject)
            ->addProduct($this->product);

        $this->assertIsRenderedCorrectly($expected, $detail);
    }

    /**
     * Assert that the $activity is rendered as $expected.
     *
     * @param string $expected
     * @param AbstractObject $activity
     * @return void
     */
    protected function assertIsRenderedCorrectly($expected, $activity)
    {
        $rendered = $this->renderer
            ->load($activity)
            ->render();

        $this->assertEquals($expected, $rendered);
    }

    /**
     * Load the content of a file for the data providers.
     *
     * @param string $filename
     * @return string
     */
    protected function loadFile($filename)
    {
        $path = __DIR__ . '/dataProviders/' . $filename;
        return file_get_contents($path);
    }

    /**
     * Data Providers
     */
    public function checkout()
    {
        return [
            [$this->loadFile('checkout.js')]
        ];
    }

    public function detail()
    {
        return [
            [$this->loadFile('detail.js')]
        ];
    }
}

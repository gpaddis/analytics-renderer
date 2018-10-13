<?php

namespace Tests\EnhancedEcommerce\Activity;

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Builder;

class ActivityTest extends TestCase
{
    public function setUp()
    {
        $this->createDummyProducts(3);
    }

    protected function createDummyProducts($n)
    {
        $this->products = [];
        for ($i = 1; $i <= $n; $i++) {
            $this->products[] = Builder::make('productFieldObject')
                ->set('id', $i)
                ->set('name', "Product $i");
        }
    }

    /** @test */
    public function it_builds_a_click_activity_object()
    {
        $click = Builder::make('click')
            ->set('actionField', ['list' => 'Search Results'])
            ->addProducts($this->products);

        $json = $click->asJson();

        $this->assertContains('"list": "Search Results"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /** @test */
    public function it_builds_a_detail_activity_object()
    {
        $detail = Builder::make('detail')
            ->set('actionField', ['list' => 'Apparel Gallery'])
            ->addProducts($this->products);

        $json = $detail->asJson();

        $this->assertContains('"list": "Apparel Gallery"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /** @test */
    public function it_builds_an_impressions_activity_object()
    {
        $impressions = Builder::make('impressions')
            ->set('currencyCode', 'EUR')
            ->addProducts($this->products);

        $json = $impressions->asJson();

        $this->assertContains('"currencyCode": "EUR"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'impressions');
    }

    /** @test */
    public function it_builds_a_purchase_activity_object()
    {
        $actionField = Builder::make('actionFieldObject')
            ->set('id', 'T12345');

        $purchase = Builder::make('purchase')
            ->set('actionField', $actionField)
            ->addProducts($this->products);

        $json = $purchase->asJson();

        $this->assertContains('"id": "T12345"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /** @test */
    public function it_builds_a_checkout_activity_object()
    {
        $actionField = Builder::make('actionFieldObject')
            ->setVariable('step', 'stepId')
            ->setVariable('option', 'optionName');

        $checkout = Builder::make('checkout')
            ->set('actionField', $actionField)
            ->addProducts($this->products);

        $json = $checkout->asJson();

        $this->assertContains('"step": stepId', $json);
        $this->assertContains('"option": optionName', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /**
     * Assert that the Json string contains the names of the products rendered
     * under the $productArrayKey specified.
     *
     * @param string $json
     * @param string $productArrayKey
     * @return void
     */
    protected function assertProductsAreRenderedCorrectly($json, $productArrayKey)
    {
        $this->assertContains($productArrayKey, $json);
        $this->assertContains('"name": "Product 1"', $json);
        $this->assertContains('"name": "Product 2"', $json);
        $this->assertContains('"name": "Product 3"', $json);
    }
}

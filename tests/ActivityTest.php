<?php

use PHPUnit\Framework\TestCase;
use Gpaddis\AnalyticsRenderer\Builder;

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

        $json = $click->renderAsJson();

        $this->assertContains('"list": "Search Results"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /** @test */
    public function it_builds_a_detail_activity_object()
    {
        $detail = Builder::make('detail')
            ->set('actionField', ['list' => 'Apparel Gallery'])
            ->addProducts($this->products);

        $json = $detail->renderAsJson();

        $this->assertContains('"list": "Apparel Gallery"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'products');
    }

    /** @test */
    public function it_builds_an_impressions_activity_object()
    {
        $impressions = Builder::make('impressions')
            ->set('currencyCode', 'EUR')
            ->addProducts($this->products);

        $json = $impressions->renderAsJson();

        $this->assertContains('"currencyCode": "EUR"', $json);
        $this->assertProductsAreRenderedCorrectly($json, 'impressions');
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

# analytics-renderer
[![Build Status](https://travis-ci.org/gpaddis/analytics-renderer.svg?branch=master)](https://travis-ci.org/gpaddis/analytics-renderer)

A library that simplifies building the objects to render as Json strings for Google Analytics.

## Examples
```php
// First build the productFieldObject(s)
$product = Builder::make('productFieldObject')
    ->set('id', '12345678');
    ->set('name', 'Test Product');

// Then build an Enhanced Ecommerce "impressions" object
$impressions = Builder::make('impressions')
    ->set('currencyCode', 'EUR')
    ->addProduct($product);

// Finally, render the impressions as Json on the page (in this case, push it to a data layer).
<script>
dataLayer.push($impressions->renderAsJson())
</script>
```
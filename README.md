# analytics-renderer
[![Build Status](https://travis-ci.org/gpaddis/analytics-renderer.svg?branch=master)](https://travis-ci.org/gpaddis/analytics-renderer)

A library that simplifies building the objects to render as Json strings for Google Analytics.

## Examples
This is how you would build a **Purchase** activity object:

```php
// First build the productFieldObject(s)
$product = Builder::make('productFieldObject')
    ->set('id', '12345678');
    ->set('name', 'Test Product')
    ->set('quantity', 1);

// Then build an actionFieldObject with the purchase ID
$actionField = Builder::make('actionFieldObject')
    ->set('id', 'T12345');

// Now build the Enhanced Ecommerce "purchase" activity object
$purchase = Builder::make('purchase')
    ->set('actionField', $actionField)
    ->addProduct($product);

// Finally, render the impressions as Json on the page and push it to the data layer.
<script>
dataLayer.push({
    'ecommerce': {
        'purchase': $purchase->asJson();
    }
});
</script>
```

The Json string will be rendered like this:
```json
{
    "actionField": {
        "id": "T12345"
    },
    "products": [
        {
            "id": 12345678,
            "name": "Test Product",
            "quantity": 1
        }
    ]
}
```
# analytics-renderer
[![Build Status](https://travis-ci.org/gpaddis/analytics-renderer.svg?branch=master)](https://travis-ci.org/gpaddis/analytics-renderer)

This library helps building and populating the data structures required by Google Analytics with server-side data fetched from your preferred PHP framework. After you prepare the objects, you can render them as Json strings and output them in your templates.

For now, the library focuses on the **Enhanced Ecommerce** data types and actions and the rendering format is compatible with an implementation using the **data layer**.

Check out the official GTM Developer Guide here: https://developers.google.com/tag-manager/enhanced-ecommerce.

## Example
This is how you would build a **Purchase** activity object and push it to the data layer:

```php
use Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Builder;

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

## Methods Overview
### Builder
First, create an instance of a fieldObject or activity with `make()`:
```php
$checkout = Builder::make('checkout'); // Returns an instance of Gpaddis\AnalyticsRenderer\EnhancedEcommerce\Activity\Checkout'
```

### Instance Methods
Once you have created an object with the builder, you can `set()` any fields you want with a fluent interface:
```php
$product = Builder::make('productFieldObject')
    ->set('id', 188828)
    ->set('name', 'Example Product')
    ->set('quantity', 2);
```

To add products to an activity that requires them, use `addProduct()` (or `addProducts()` if you pass an array of products):
```php
$checkout->addProduct($product);
```


If one of the fields depends on user interaction and you can only fetch it dynamically on the client side with JavaScript, it might be a good idea to use a variable instead. The method `setVariable()` will render the name of the variable without quotes:

```php
$actionField = Builder::make('actionFieldObject')
    ->setVariable('step', 'stepId')
    ->setVariable('option', 'optionName');
```

This will render to:
```js
{
    "step": stepId,
    "option": optionName
}
```

This way you can push the object inside a JavaScript function that accepts the parameters `stepId` and `optionName`, for example. To render the Json string, simply call `toJson()` or `toMinifiedJson()` at the end of the chain.
```php
$checkout->set('actionField', $actionField)
    ->asJson();
```
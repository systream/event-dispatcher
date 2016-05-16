# Event dispatcher
Observer for events

## Usage Examples

### Subscribe to event

```php
$eventDispatcher = new EventDispatcher();

$subscription = new EventDispatcher\Subscription('nameOfEvent', function (EventInterface $event) {
	// do stuff here
});
$eventDispatcher->subscribe($subscription);
```

### Fire an event

```php
$eventDispatcher = new EventDispatcher();
$eventDispatcher->emit(new EventDispatcher\Event('nameOfEvent'));

```

### Stop Propagation

```php
$eventDispatcher = new EventDispatcher();

$subscription = new EventDispatcher\Subscription('fooBar', function (EventDispatcher\EventInterface $event) {
	$event->stopPropagation();
});
$eventDispatcher->subscribe($subscription);

$subscription2 = new EventDispatcher\Subscription('fooBar', function (EventDispatcher\EventInterface $event) {
	// do stuff here
});
$eventDispatcher->subscribe($subscription2);

$eventDispatcher->emit(new EventDispatcher\Event('fooBar'));

```
In this case the second subscription won't be invoked.

### Custom events
The only thing you need to do is that implementing the ```EventInterface```

```php
class MyCustomEvent extends AbstractEvent implements EventInterface
{

	/**
	 * @var string
	 */
	protected $key = 'order.save';

	/**
	 * @var Order
	 */
	protected $order;

	/**
	 * @param string $key
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * @return Order
	 */
	public function getOrder()
	{
		return $this->order;
	}
}

...

$eventDispatcher = new EventDispatcher();
$subscription = new EventDispatcher\Subscription('nameOfEvent', function (OrderEvent $event) {
	$order = $orderEvent->getOrder();
	// do stuff
});
$eventDispatcher->subscribe($subscription);

```

### Custom Subscriptions

The only thing you need to do is that implementing the ```SubscriptionInterface```

## Test

[![Build Status](https://travis-ci.org/systream/feature-switch.svg?branch=master)](https://travis-ci.org/systream/event-dispatcher)
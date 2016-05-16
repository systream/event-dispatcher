# Event dispatcher
Observer for events

## Usage Examples

### Subscribe to event


```php
$eventDispatcher = new EventDispatcher();

$subscription = new EventDispatcher\Subscription('fooBar', function (EventDispatcher\EventInterface $event) {
	// do stuff here
});
$eventDispatcher->subscribe($subscription);
```

### Fire an event

```php
$eventDispatcher = new EventDispatcher();
$eventDispatcher->emit(new EventDispatcher\Event('fooBar'));

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
In this case the second subscription won't be invoked
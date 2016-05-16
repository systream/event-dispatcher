<?php

namespace Tests\Systream\Unit;


use Systream\EventDispatcher;

class EventDispatcherTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @test
	 */
	public function subscribeToEvent_eventNotExists()
	{
		$eventDispatcher = new EventDispatcher();

		$subscription = $this->getSubscriptionMock('foo');
		$eventDispatcher->subscribe($subscription);
		
		$this->assertEquals(array($subscription), $eventDispatcher->getSubscriptions('foo'));
	}

	/**
	 * @test
	 */
	public function getSubscriptions_eventNotExists_NoSubscriptions()
	{
		$eventDispatcher = new EventDispatcher();
		$this->assertEquals(array(), $eventDispatcher->getSubscriptions('bar'));
	}

	/**
	 * @test
	 */
	public function fireEvent()
	{
		$eventDispatcher = new EventDispatcher();
		$event = $this->getEventMock('fooBar');
		
		$subscription = $this->getSubscriptionMock('fooBar');
		$subscription->expects($this->exactly(1))
			->method('run');
		$eventDispatcher->subscribe($subscription);

		$subscription2 = $this->getSubscriptionMock('fooBar');
		$subscription2->expects($this->exactly(1))
			->method('run');
		$eventDispatcher->subscribe($subscription2);
		
		$eventDispatcher->emit($event);
	}

	/**
	 * @test
	 */
	public function fireEvent_noSubscriptions()
	{
		$eventDispatcher = new EventDispatcher();
		$event = $this->getEventMock('fooBar');
		$eventDispatcher->emit($event);
	}

	/**
	 * @test
	 */
	public function fireEvent_fireOrder()
	{
		$eventDispatcher = new EventDispatcher();
		$event = $this->getEventMock('fooBar');

		$eventHistory = array();

		$eventDispatcher->subscribe(new EventDispatcher\Subscription('fooBar', function ($event) use (&$eventHistory) {
			$eventHistory[] = 'first';
		}));

		$eventDispatcher->subscribe(new EventDispatcher\Subscription('fooBar', function ($event) use (&$eventHistory) {
			$eventHistory[] = 'second';
		}));

		$eventDispatcher->emit($event);
		
		$this->assertEquals(array('first', 'second'), $eventHistory);
	}

	/**
	 * @test
	 */
	public function fireEvent_stopPropagation()
	{
		$eventDispatcher = new EventDispatcher();
		$event = new EventDispatcher\Event('fooBar');

		$subscription1 = new EventDispatcher\Subscription('fooBar', function (EventDispatcher\EventInterface $event) use (&$eventHistory) {
			$eventHistory[] = 'first';
			$event->stopPropagation();
		});
		$eventDispatcher->subscribe($subscription1);

		$subscription2 = new EventDispatcher\Subscription('fooBar', function ($event) use (&$eventHistory) {
			$eventHistory[] = 'second';
		});
		
		$eventDispatcher->subscribe($subscription2);

		$eventDispatcher->emit($event);

		$this->assertEquals(array('first'), $eventHistory);
		
	}

	/**
	 * @param string $key
	 * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcher\EventInterface
	 */
	protected function getEventMock($key = '')
	{
		$event = $this->getMockBuilder('\Systream\EventDispatcher\EventInterface')
			->getMock();

		if ($key) {
			$event->expects($this->any())
				->method('getKey')
				->will($this->returnValue($key));
		}

		return $event;
	}

	/**
	 * @param string $key
	 * @return \PHPUnit_Framework_MockObject_MockObject|EventDispatcher\SubscriptionInterface
	 */
	protected function getSubscriptionMock($key = '')
	{
		$subscription = $this->getMockBuilder('\Systream\EventDispatcher\SubscriptionInterface')->getMock();
		if ($key) {
			$subscription->expects($this->any())
				->method('getEventKey')
				->will($this->returnValue($key));
		}
		return $subscription;
	}

}

<?php

namespace Systream;


use Systream\EventDispatcher\EventInterface;
use Systream\EventDispatcher\SubscriptionInterface;

class EventDispatcher
{

	/**
	 * @var EventInterface[]
	 */
	protected $events = array();

	/**
	 * @var SubscriptionInterface[]
	 */
	protected $subscriptions = array();
	
	/**
	 * @param SubscriptionInterface $subscription
	 */
	public function subscribe(SubscriptionInterface $subscription)
	{
		if (!isset($this->subscriptions[$subscription->getEventKey()])) {
			$this->subscriptions[$subscription->getEventKey()] = array();
		}

		$this->subscriptions[$subscription->getEventKey()][] = $subscription;
	}

	/**
	 * @param EventInterface $event
	 */
	public function emit(EventInterface $event)
	{
		$eventKey = $event->getKey();
		if (!isset($this->subscriptions[$eventKey])) {
			return;
		}

		/** @var SubscriptionInterface $subscription */
		foreach ($this->subscriptions[$eventKey] as $subscription) {
			$subscription->run($event);
			if ($event->isPropagationStopped()) {
				return;
			}
		}
	}

	/**
	 * @param string $eventKey
	 * @return array
	 */
	public function getSubscriptions($eventKey)
	{
		if (!isset($this->subscriptions[$eventKey])) {
			return array();
		}

		return $this->subscriptions[$eventKey];
	}
}
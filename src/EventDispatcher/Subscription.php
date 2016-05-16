<?php

namespace Systream\EventDispatcher;


class Subscription implements SubscriptionInterface
{
	/**
	 * @var
	 */
	protected $eventKey;
	
	/**
	 * @var \Closure
	 */
	protected $closure;

	/**
	 * Subscription constructor.
	 * @param $eventKey
	 * @param \Closure $closure
	 */
	public function __construct($eventKey, \Closure $closure)
	{
		$this->eventKey = $eventKey;
		$this->closure = $closure;
	}

	/**
	 * @return string
	 */
	public function getEventKey()
	{
		return $this->eventKey;
	}

	/**
	 * @param EventInterface $event
	 */
	public function run(EventInterface $event)
	{
		$closure = $this->closure;
		return $closure($event);
	}

}
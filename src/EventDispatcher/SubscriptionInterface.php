<?php

namespace Systream\EventDispatcher;


interface SubscriptionInterface
{

	/**
	 * @return string
	 */
	public function getEventKey();
	
	/**
	 * @param EventInterface $event
	 */
	public function run(EventInterface $event);

}
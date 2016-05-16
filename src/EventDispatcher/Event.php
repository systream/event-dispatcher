<?php

namespace Systream\EventDispatcher;


class Event extends AbstractEvent
{
	/**
	 * @param string $key
	 */
	public function __construct($key)
	{
		$this->key = $key;
	}
}
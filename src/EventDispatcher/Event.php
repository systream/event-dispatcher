<?php

namespace Systream\EventDispatcher;


class Event implements EventInterface
{
	/**
	 * @var
	 */
	protected $key;

	/**
	 * @var bool
	 */
	protected $isPropagationStopped = false;

	/**
	 * @param string $key
	 */
	public function __construct($key)
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @return void
	 */
	public function stopPropagation()
	{
		$this->isPropagationStopped = true;
	}

	/**
	 * @return bool
	 */
	public function isPropagationStopped()
	{
		return $this->isPropagationStopped;
	}
}
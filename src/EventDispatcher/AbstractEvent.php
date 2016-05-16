<?php

namespace Systream\EventDispatcher;


abstract class AbstractEvent implements EventInterface
{
	/**
	 * @var string
	 */
	protected $key = '';

	/**
	 * @var bool
	 */
	protected $isPropagationStopped = false;

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
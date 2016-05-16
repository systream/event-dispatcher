<?php

namespace Systream\EventDispatcher;


interface EventInterface
{
	/**
	 * @return string
	 */
	public function getKey();

	/**
	 * @return void
	 */
	public function stopPropagation();

	/**
	 * @return bool
	 */
	public function isPropagationStopped();
}
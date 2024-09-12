<?php

namespace Naper\Vtex\Repositories\Traits;

trait HasAsync
{
	protected bool $isAsync = false;

	/**
	 * Set the request to be asynchronous.
	 *
	 * @return $this
	 */
	public function async(): self
	{
		$this->isAsync = true;
		return $this;
	}
}
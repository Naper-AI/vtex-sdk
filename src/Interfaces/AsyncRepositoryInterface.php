<?php

namespace Naper\Vtex\Interfaces;

interface AsyncRepositoryInterface
{
	/**
	 * Set the request to be asynchronous.
	 *
	 * @return $this
	 */
	public function async(): self;
}
<?php

namespace Naper\Vtex\Repositories\Traits;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Promise\Utils;

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
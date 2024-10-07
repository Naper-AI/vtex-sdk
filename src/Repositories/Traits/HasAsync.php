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

	/**
	 * Resolve promises in chunks.
	 *
	 * @param array $promises
	 * @param int $chunkSize
	 */
	protected function chunkResolver(array $promises, int $chunkSize = 50): PromiseInterface
	{
		if (count($promises) <= $chunkSize) {
			return Utils::all($promises);
		}

		$chunks = array_chunk($promises, $chunkSize);
		$promises = array_map(function ($batch) {
			return Utils::all($batch);
		}, $chunks);

		return $this->recursiveResolver($promises)
			->then(fn ($responses) => array_merge(...$responses));
	}

	private function recursiveResolver(array $promises): PromiseInterface
	{
		$mainPromise = new Promise(function () use (&$mainPromise, $promises) {
			/** @var PromiseInterface $mainPromise */
			$responses = [];
			foreach ($promises as $key => $promise) {
				$fulfilled = true;
				$responses[$key] = $promise->then(
					onFulfilled: fn ($result) => $result,
					onRejected: function ($reason) use (&$mainPromise, &$fulfilled) {
						$fulfilled = false;
						$mainPromise->reject($reason);
					}
				)->wait();

				if (!$fulfilled) {
					return;
				}
			}

			$mainPromise->resolve($responses);
		});

		return $mainPromise;
	}
}
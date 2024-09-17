<?php

namespace Naper\Vtex\Repositories\Catalog;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;
use Exception;

/**
 * @todo Delete this class and migrate getMultipleAsync
 * to a trait or inner method with Utils::all instead of Pool class
 */
abstract class AbstractRepository extends \Naper\Vtex\Repositories\AbstractRepository
{
	protected int $concurrency = 5;

	protected function getMultipleAsync(array $urls): array
	{
		$requests = function ($urls) {
			foreach ($urls as $url) {
				yield new Request('GET', $url, $this->getHeaders());
			}
		};

		$results = [];
		$pool = new Pool($this->client, $requests($urls), [
			'concurrency' => $this->concurrency,
			'fulfilled' => function ($response, $index) use (&$results) {
				$results[$index] = $response;
			},
			'rejected' => function ($reason, $index) {
				throw new Exception('Error: ' . $reason->getMessage());
			},
		]);

		$promise = $pool->promise();
		$promise->wait();

		return $results;
	}
}
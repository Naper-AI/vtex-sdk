<?php

namespace VtexSdk\Repositories\Catalog;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Exception;

abstract class AbstractRepository
{
	protected Client $client;
	protected string $baseUrl;
	protected string $AppKey;
	protected string $AppToken;
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

	protected function getHeaders(): array
	{
		return [
			'Accept' => 'application/json',
			'Content-Type' => 'application/json',
			'X-VTEX-API-AppKey' => $this->AppKey,
			'X-VTEX-API-AppToken' => $this->AppToken,
		];
	}
}
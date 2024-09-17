<?php

namespace Naper\Vtex\Repositories\Catalog;

use GuzzleHttp\Promise\Utils;

/**
 * @todo Delete this class and migrate getMultipleAsync
 * to a trait or inner method with Utils::all instead of Pool class
 */
abstract class AbstractRepository extends \Naper\Vtex\Repositories\AbstractRepository
{
	protected function getMultipleAsync(array $urls): array
	{
		$promise = Utils::all(array_map(function ($url) {
			return $this->client->requestAsync('GET', $url, [
				'headers' => $this->getHeaders()
			]);
		}, $urls));

		return $promise->wait();
	}
}
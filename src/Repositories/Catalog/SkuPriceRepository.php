<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Interfaces\Catalog\SkuPriceRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use Naper\Vtex\Entities\Catalog\SkuPrice;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SkuPriceRepository extends AbstractRepository implements SkuPriceRepositoryInterface
{
	use HasAsync;

	public function __construct(
		protected EntityFactory $factory,
		protected Client $client,
		protected string $baseUrl,
		protected string $appKey,
		protected string $appToken,
		protected string $accountName,
	) {
		//
	}

	public function get(int $id): SkuPrice|PromiseInterface
	{
		$url = "https://api.vtex.com/{$this->accountName}/pricing/prices/{$id}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$value = $this->factory->make(SkuPrice::class, ...$data);
			return $value;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(SkuPrice $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(SkuPrice $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Interfaces\Catalog\BrandRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Brand;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
	use HasAsync;

	public function __construct(
		protected EntityFactory $factory,
		protected Client $client,
		protected string $baseUrl,
		protected string $appKey,
		protected string $appToken,
	) {
		//
	}

	public function get(int $id): Brand|PromiseInterface
	{
		$url = $this->baseUrl . '/api/catalog_system/pvt/brand/' . $id;
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$value = $this->factory->make(Brand::class, ...$data);
			return $value;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(Brand $brand): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(Brand $brand): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
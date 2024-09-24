<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Interfaces\Catalog\BrandRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Brand;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;
use GuzzleHttp\Promise\Create;

/**
 * @todo implement missing methods
 */
class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
	use HasAsync;

	protected array $cache = [];

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
		if (isset($this->cache[$id])) {
			if ($this->cache[$id] instanceof PromiseInterface) {
				return $this->isAsync ? $this->cache[$id] : $this->cache[$id]->wait();
			}
			return $this->isAsync ? Create::promiseFor($this->cache[$id]) : $this->cache[$id];
		}

		$url = $this->baseUrl . '/api/catalog_system/pvt/brand/' . $id;
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) use ($id) {
			$body = $res->getBody();
			$data = json_decode($body, true);

			$value = $this->factory->make(Brand::class, ...$data);

			$this->cache[$id] = $value;
			return $value;
		});

		$this->cache[$id] = $promise;
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
<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\Specification;
use Naper\Vtex\Interfaces\Catalog\SpecificationRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SpecificationRepository extends AbstractRepository implements SpecificationRepositoryInterface
{
	use HasAsync;

	private array $cache = [];

	public function __construct(
		protected EntityFactory $factory,
		protected Client $client,
		protected string $baseUrl,
		protected string $appKey,
		protected string $appToken,
	) {
		//
	}

	public function get(int $id): Specification|PromiseInterface
	{
		if (isset($this->cache[$id])) {
			return $this->cache[$id];
		}

		$url = $this->baseUrl . "/api/catalog/pvt/specificationvalue/{$id}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$body = $res->getBody();
			$data = json_decode($body, true);

			$specification = $this->factory->make(Specification::class,
				id: $data['Id'],
				skuId: $data['SkuId'],
				fieldId: $data['FieldId'],
				fieldValueId: $data['FieldValueId'],
				text: $data['Text'],
			);

			$this->cache[$specification->id] = $specification;
			return $specification;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(Specification $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(Specification $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
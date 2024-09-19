<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\SpecificationValue;
use Naper\Vtex\Interfaces\Catalog\SpecificationValueRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SpecificationValueRepository extends AbstractRepository implements SpecificationValueRepositoryInterface
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

	public function get(int $id): null|SpecificationValue|PromiseInterface
	{
		if (isset($this->cache[$id])) {
			return $this->cache[$id];
		}

		$url = $this->baseUrl . "/api/catalog/pvt/specificationvalue/{$id}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode === 404) {
				return null;
			}

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$value = $this->factory->make(SpecificationValue::class,
				fieldValueId: $data['FieldValueId'],
				fieldId: $data['FieldId'],
				name: $data['Name'],
				text: $data['Text'],
				isActive: $data['IsActive'],
				position: $data['Position'],
			);

			$this->cache[$value->fieldValueId] = $value;
			return $value;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(SpecificationValue $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(SpecificationValue $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
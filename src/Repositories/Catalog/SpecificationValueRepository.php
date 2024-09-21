<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\SpecificationValue;
use Naper\Vtex\Interfaces\Catalog\SpecificationValueRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
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

	public function getValues(int $fieldId): Collection|PromiseInterface
	{
		if (isset($this->cache[$fieldId])) {
			return $this->cache[$fieldId];
		}

		$url = $this->baseUrl . "/api/catalog_system/pub/specification/fieldvalue/{$fieldId}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) use ($fieldId) {
			$body = $res->getBody();
			$data = json_decode($body, true);

			$values = new ArrayCollection(
				array_map(fn ($item) => $this->factory->make(SpecificationValue::class,
					fieldValueId: $item['FieldValueId'],
					fieldId: $fieldId,
					value: $item['Value'],
					isActive: $item['IsActive'],
					position: $item['Position'],
				), $data)
			);

			$this->cache[$fieldId] = $values;
			return $values;
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
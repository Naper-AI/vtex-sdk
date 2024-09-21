<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\SkuSpecification;
use Naper\Vtex\Interfaces\Catalog\SkuSpecificationRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SkuSpecificationRepository extends AbstractRepository implements SkuSpecificationRepositoryInterface
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

	public function getBySkuId(int $id): Collection|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog/pvt/stockkeepingunit/{$id}/specification";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$body = $res->getBody();
			$data = json_decode($body, true);
			$skus = array_map(function ($item) {
				return $this->factory->make(SkuSpecification::class,
					id: $item['Id'],
					skuId: $item['SkuId'],
					fieldId: $item['FieldId'],
					fieldValueId: $item['FieldValueId'],
					text: $item['Text'],
				);
			}, $data);

			return new ArrayCollection($skus);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(SkuSpecification $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(SkuSpecification $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
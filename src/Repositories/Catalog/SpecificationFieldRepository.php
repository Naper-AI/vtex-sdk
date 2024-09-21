<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\SpecificationField;
use Naper\Vtex\Interfaces\Catalog\SpecificationFieldRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SpecificationFieldRepository extends AbstractRepository implements SpecificationFieldRepositoryInterface
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

	public function get(int $id): SpecificationField|PromiseInterface
	{
		if (isset($this->cache[$id])) {
			return $this->cache[$id];
		}

		$url = $this->baseUrl . "/api/catalog_system/pub/specification/fieldGet/{$id}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$body = $res->getBody();
			$data = json_decode($body, true);

			$value = $this->factory->make(SpecificationField::class,
				name: $data['Name'],
				fieldId: $data['FieldId'],
				isActive: $data['IsActive'],
				isRequired: $data['IsRequired'],
				fieldTypeId: $data['FieldTypeId'],
				fieldTypeName: $data['FieldTypeName'],
				fieldValueId: $data['FieldValueId'],
				isStockKeepingUnit: $data['IsStockKeepingUnit'],
				isFilter: $data['IsFilter'],
				isOnProductDetails: $data['IsOnProductDetails'],
				position: $data['Position'],
				isTopMenuLinkActive: $data['IsTopMenuLinkActive'],
				isSideMenuLinkActive: $data['IsSideMenuLinkActive'],
				defaultValue: $data['DefaultValue'],
				fieldGroupId: $data['FieldGroupId'],
				fieldGroupName: $data['FieldGroupName'],
			);

			$this->cache[$value->fieldValueId] = $value;
			return $value;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(SpecificationField $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(SpecificationField $specification): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
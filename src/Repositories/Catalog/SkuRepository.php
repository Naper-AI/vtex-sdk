<?php

namespace VtexSdk\Repositories\Catalog;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Orkestra\Entities\EntityFactory;
use VtexSdk\Interfaces\SkuRepositoryInterface;
use VtexSdk\Entities\Catalog\Sku;
use VtexSdk\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

class SkuRepository extends AbstractRepository implements SkuRepositoryInterface
{
	use HasAsync;

	public function __construct(
		protected EntityFactory $factory,
		protected Client $client,
		protected string $baseUrl,
		protected string $AppKey,
		protected string $AppToken,
	) {
		//
	}

	public function getByProductId(int $id): Collection|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog_system/pvt/sku/stockkeepingunitByProductId/{$id}";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$skus = array_map(function ($item) {
				foreach ($item as $key => $value) {
					$item[lcfirst($key)] = $value;
					unset($item[$key]);
				}

				$item['kitItemsSellApart'] = $item['flagKitItensSellApart'];

				// Fix the width and height from this call to match the other calls (vtex inconsistency)
				$item['packagedHeight'] = $item['height'];
				$item['packagedLength'] = $item['length'];
				$item['packagedWidth'] = $item['width'];
				$item['packagedWeightKg'] = $item['weightKg'];
				$item['width'] = $item['realWidth'];
				$item['height'] = $item['realHeight'];
				$item['length'] = $item['realLength'];
				$item['weightKg'] = $item['realWeightKg'];

				unset($item['isPersisted']);
				unset($item['modalId']);
				unset($item['internalNote']);
				unset($item['dateUpdated']);
				unset($item['estimatedDateArrival']);
				unset($item['referenceStockKeepingUnitId']);
				unset($item['position']);
				unset($item['isInventoried']);
				unset($item['isTransported']);
				unset($item['isGiftCardRecharge']);
				unset($item['flagKitItensSellApart']);
				unset($item['realWidth']);
				unset($item['realHeight']);
				unset($item['realLength']);
				unset($item['realWeightKg']);

				return $this->factory->make(Sku::class, ...$item);
			}, $data);

			return new ArrayCollection($skus);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function getEanCode(Sku $sku): string|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog/pvt/stockkeepingunit/{$sku->id}/ean";

		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);
			return $data[0] ?? '';
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(Sku $sku): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(Sku $sku): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
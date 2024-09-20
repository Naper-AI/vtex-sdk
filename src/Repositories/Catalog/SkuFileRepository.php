<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Entities\Catalog\SkuFile;
use Naper\Vtex\Interfaces\Catalog\SkuFileRepositoryInterface;
use Naper\Vtex\Repositories\Traits\HasAsync;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;

/**
 * @todo implement missing methods
 */
class SkuFileRepository extends AbstractRepository implements SkuFileRepositoryInterface
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

	public function getBySkuId(int $id): Collection|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog/pvt/stockkeepingunit/{$id}/file";
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
				$url = $item['Url'] ?? null;
				$url ??= $item['FileLocation'] ? 'https://' . $this->accountName . '.' . $item['FileLocation'] : null;
				return $this->factory->make(SkuFile::class,
					id: $item['Id'],
					archiveId: $item['ArchiveId'],
					skuId: $item['SkuId'],
					name: $item['Name'],
					isMain: $item['IsMain'],
					text: $item['Text'],
					label: $item['Label'],
					url: $url,
					fileLocation: $item['FileLocation'],
				);
			}, $data);

			return new ArrayCollection($skus);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(SkuFile $file): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(SkuFile $file): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}
}
<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Naper\Vtex\Entities\Catalog\Product;
use Naper\Vtex\Interfaces\ProductRepositoryInterface;
use Naper\Vtex\Entities\Catalog\ProductSpecification;
use Naper\Vtex\Repositories\Traits\HasAsync;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use Exception;
use DateTime;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
	use HasAsync;

	private int $offset = 0;
	private int $length = 100;

	public function __construct(
		protected EntityFactory $factory,
		protected Client $client,
		protected string $baseUrl,
		protected string $AppKey,
		protected string $AppToken,
		protected int $concurrency = 50,
	) {
		//	
	}

	public function getIterator(): Collection
	{
		$from = $this->offset + 1;
		$to = $this->offset + $this->length;

		$urls = [];
		for ($i = $from; $i <= $to; $i += 250) {
			if ($i + 250 > $to) {
				$urls[] = $this->baseUrl . "/api/catalog_system/pvt/products/GetProductAndSkuIds?_from={$i}&_to={$to}";
				break;
			}
			$urls[] = $this->baseUrl . "/api/catalog_system/pvt/products/GetProductAndSkuIds?_from={$i}&_to=" . ($i + 250);
		}

		$results = $this->getMultipleAsync($urls);

		$productSdks = [];
		foreach ($results as $response) {
			$statusCode = $response->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $response->getBody();
			$data = json_decode($body, true)['data'] ?? [];
			$productSdks = $productSdks + $data; // Keep the array keys
		}

		ksort($productSdks);
		$productIds = array_keys($productSdks);

		if (empty($productIds)) {
			return new ArrayCollection([]);
		}

		$results = $this->getMultipleAsync(
			urls: array_map(fn ($id) => $this->baseUrl . '/api/catalog/pvt/product/' . $id, $productIds)
		);

		foreach ($results as $response) {
			$statusCode = $response->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $response->getBody();
			$data = json_decode($body, true);

			foreach ($data as $key => $value) {
				$data[lcfirst($key)] = $value;
				unset($data[$key]);
			}

			$data['releaseDate'] = new DateTime($data['releaseDate']);
			$data['keyWords'] = explode(',', $data['keyWords']);
			$data['keyWords'] = array_map('trim', $data['keyWords']);

			$products[] = $this->factory->make(Product::class, ...$data);
		}

		return new ArrayCollection($products);
	}

	public function slice(int $offset, int $length): self
	{
		$clone = clone $this;
		$clone->offset = $offset;
		$clone->length = $length;
		return $clone;
	}

	public function update(Product $product): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function create(Product $product): null|PromiseInterface
	{
		throw new Exception('Method not implemented');
	}

	public function count(): int
	{
		$url = $this->baseUrl . '/api/catalog_system/pvt/products/GetProductAndSkuIds?_from=1&_to=1';
		$res = $this->client->request('GET', $url, [
			'headers' => $this->getHeaders()
		]);

		$statusCode = $res->getStatusCode();

		if ($statusCode !== 200) {
			throw new Exception('Error: ' . $statusCode);
		}

		$body = $res->getBody();
		$data = json_decode($body, true);
		return $data['range']['total'];
	}

	public function getSpecifications(Product $product): Collection|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog_system/pvt/products/{$product->id}/specification";
		$promise = $this->client->getAsync($url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);
			$items = array_map(fn ($item) => $this->factory->make(
				ProductSpecification::class,
				id: $item['Id'],
				name: $item['Name'],
				values: array_filter($item['Value'], fn ($value) => !empty($value))
			), $data);

			return new ArrayCollection($items);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}
}
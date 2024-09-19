<?php

namespace Naper\Vtex\Repositories\Catalog;

use Orkestra\Entities\EntityFactory;
use Naper\Vtex\Interfaces\Catalog\CategoryRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Category;
use Naper\Vtex\Entities\Catalog\CategoryTree;
use Naper\Vtex\Entities\Catalog\Product;
use Naper\Vtex\Repositories\Traits\HasAsync;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Create;
use Exception;

/**
 * @todo implement missing methods
 */
class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
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

	public function all(): Collection|PromiseInterface
	{
		$url = $this->baseUrl . '/api/catalog_system/pub/category/tree/100';
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$categories = array_map(fn ($item) => $this->factory->make(
				CategoryTree::class,
				id: $item['id'],
				name: $item['name'],
				hasChildren: $item['hasChildren'],
				url: $item['url'],
				title: $item['Title'],
				metaTagDescription: $item['MetaTagDescription'],
				children: $item['children'] ?? []
			), $data);

			$toCache = [];
			foreach ($categories as $category) {
				$toCache[$category->id] = $category;
			}

			$this->cache += $toCache;

			return new ArrayCollection($categories);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function get(int $id): Category|PromiseInterface
	{
		if (isset($this->cache[$id])) {
			return $this->isAsync ? Create::promiseFor($this->cache[$id]) : $this->cache[$id];
		}

		$url = $this->baseUrl . '/api/catalog/pvt/category/' . $id;
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$body = $res->getBody();
			$data = json_decode($body, true);

			$category = $this->factory->make(
				Category::class,
				id: $data['Id'],
				name: $data['Name'],
				fatherCategoryId: $data['FatherCategoryId'],
				title: $data['Title'],
				description: $data['Description'],
				keywords: array_map('trim', explode(',', $data['Keywords'])),
				isActive: $data['IsActive'],
				lomadeeCampaignCode: $data['LomadeeCampaignCode'],
				adWordsRemarketingCode: $data['AdWordsRemarketingCode'],
				showInStoreFront: $data['ShowInStoreFront'],
				showBrandFilter: $data['ShowBrandFilter'],
				activeStoreFrontLink: $data['ActiveStoreFrontLink'],
				globalCategoryId: $data['GlobalCategoryId'],
				stockKeepingUnitSelectionMode: $data['StockKeepingUnitSelectionMode'],
				score: $data['Score'],
				linkId: $data['LinkId'],
				hasChildren: $data['HasChildren']
			);

			$this->cache[$category->id] = $category;

			return $category;
		});

		return $this->isAsync ? $promise : $promise->wait();
	}

	public function update(Category $category): PromiseInterface|null
	{
		throw new \Exception('Method not implemented');
	}

	public function create(Category $category): PromiseInterface|null
	{
		throw new \Exception('Method not implemented');
	}

	public function getSimilarCategories(Product $product): Collection|PromiseInterface
	{
		$url = $this->baseUrl . "/api/catalog/pvt/product/{$product->id}/similarcategory";
		$promise = $this->client->requestAsync('GET', $url, [
			'headers' => $this->getHeaders()
		])->then(function ($res) {
			$statusCode = $res->getStatusCode();

			if ($statusCode !== 200) {
				throw new Exception('Error: ' . $statusCode);
			}

			$body = $res->getBody();
			$data = json_decode($body, true);

			$idsToSearch = array_map(fn ($item) => $item['CategoryId'], $data);

			$cached = array_filter($idsToSearch, fn ($id) => isset($this->cache[$id]));
			$idsToSearch = array_diff($idsToSearch, $cached);

			if (count($idsToSearch) === 0) {
				$categories = array_map(fn ($id) => $this->cache[$id], $cached);
				return new ArrayCollection($categories);
			}

			$categoryUrl = fn ($id) => $this->baseUrl . '/api/catalog/pvt/category/' . $id;
			$categoriesUrls = array_map(fn ($id) => $categoryUrl($id), $idsToSearch);

			$categories = $this->getMultipleAsync($categoriesUrls);
			$categories = array_map(function ($response) {
				$statusCode = $response->getStatusCode();

				if ($statusCode !== 200) {
					throw new Exception('Error: ' . $statusCode);
				}

				$body = $response->getBody();
				$data = json_decode($body, true);

				return $this->factory->make(
					Category::class,
					id: $data['Id'],
					name: $data['Name'],
					fatherCategoryId: $data['FatherCategoryId'],
					title: $data['Title'],
					description: $data['Description'],
					keywords: array_map('trim', explode(',', $data['Keywords'])),
					isActive: $data['IsActive'],
					lomadeeCampaignCode: $data['LomadeeCampaignCode'],
					adWordsRemarketingCode: $data['AdWordsRemarketingCode'],
					showInStoreFront: $data['ShowInStoreFront'],
					showBrandFilter: $data['ShowBrandFilter'],
					activeStoreFrontLink: $data['ActiveStoreFrontLink'],
					globalCategoryId: $data['GlobalCategoryId'],
					stockKeepingUnitSelectionMode: $data['StockKeepingUnitSelectionMode'],
					score: $data['Score'],
					linkId: $data['LinkId'],
					hasChildren: $data['HasChildren']
				);
			}, $categories);

			$toCache = [];
			foreach ($categories as $category) {
				$toCache[$category->id] = $category;
			}

			$this->cache = $this->cache + $toCache;

			$cachedEntities = array_map(fn ($id) => $this->cache[$id], $cached);
			$categories = array_merge($categories, $cachedEntities);
			return new ArrayCollection($categories);
		});

		return $this->isAsync ? $promise : $promise->wait();
	}
}
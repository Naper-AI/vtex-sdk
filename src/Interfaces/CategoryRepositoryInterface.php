<?php

namespace Naper\Vtex\Interfaces;

use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use Naper\Vtex\Entities\Catalog\CategoryTree;
use Naper\Vtex\Entities\Catalog\Category;
use Naper\Vtex\Entities\Catalog\Product;

interface CategoryRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Collection<array-key,CategoryTree>|PromiseInterface<Collection<array-key,CategoryTree>>
	 */
	public function all(): Collection|PromiseInterface;

	public function update(Category $category): PromiseInterface|null;

	public function create(Category $category): PromiseInterface|null;

	/**
	 * @return Category|PromiseInterface<Category>
	 */
	public function get(int $id): Category|PromiseInterface;

	/**
	 * @return Collection<array-key,Category>|PromiseInterface<Collection<array-key,Category>>
	 */
	public function getSimilarCategories(Product $product): Collection|PromiseInterface;
}
<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\ProductSpecification;
use Naper\Vtex\Entities\Catalog\Product;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use Countable;

interface ProductRepositoryInterface extends AsyncRepositoryInterface, Countable
{
	/**
	 * @return int[]|PromiseInterface<int[]>
	 */
	public function getIds(): array|PromiseInterface;

	/**
	 * @return Collection<array-key,Product>|PromiseInterface<Collection<array-key,Product>>
	 */
	public function getIterator(): Collection|PromiseInterface;

	public function get(int $id): null|Product|PromiseInterface;

	/**
	 * @return $this
	 */
	public function slice(int $offset, int $length): self;

	public function update(Product $category): null|PromiseInterface;

	public function create(Product $category): null|PromiseInterface;

	/**
	 * @return Collection<array-key,ProductSpecification>|PromiseInterface<Collection<array-key,ProductSpecification>>
	 */
	public function getSpecifications(Product $product): Collection|PromiseInterface;
}
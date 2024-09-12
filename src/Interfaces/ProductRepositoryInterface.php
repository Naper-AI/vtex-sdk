<?php

namespace Naper\Vtex\Interfaces;

use Doctrine\Common\Collections\Collection;

use Naper\Vtex\Entities\Catalog\Product;
use GuzzleHttp\Promise\PromiseInterface;
use Naper\Vtex\Entities\Catalog\ProductSpecification;
use Countable;

interface ProductRepositoryInterface extends AsyncRepositoryInterface, Countable
{
	/**
	 * @return Collection<array-key,Product>
	 */
	public function getIterator(): Collection;

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
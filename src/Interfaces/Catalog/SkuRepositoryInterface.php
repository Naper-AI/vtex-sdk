<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Sku;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;

interface SkuRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Collection<array-key,Sku>|PromiseInterface<Collection<array-key,Sku>>
	 */
	public function getByProductId(int $productId): Collection|PromiseInterface;

	/**
	 * @return string|PromiseInterface<string>
	 */
	public function getEanCode(Sku $sku): string|PromiseInterface;

	public function update(Sku $sku): null|PromiseInterface;

	public function create(Sku $sku): null|PromiseInterface;
}
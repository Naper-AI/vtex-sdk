<?php

namespace Naper\Vtex\Interfaces;

use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;
use Naper\Vtex\Entities\Catalog\Sku;

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
<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SkuPrice;
use GuzzleHttp\Promise\PromiseInterface;

interface SkuPriceRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return null|SkuPrice|PromiseInterface<SkuPrice>
	 */
	public function get(int $id): null|SkuPrice|PromiseInterface;

	public function update(SkuPrice $price): null|PromiseInterface;

	public function create(SkuPrice $price): null|PromiseInterface;
}
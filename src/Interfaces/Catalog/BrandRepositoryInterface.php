<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Brand;
use GuzzleHttp\Promise\PromiseInterface;

interface BrandRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Brand|PromiseInterface<Brand>
	 */
	public function get(int $id): Brand|PromiseInterface;

	public function update(Brand $brand): null|PromiseInterface;

	public function create(Brand $brand): null|PromiseInterface;
}
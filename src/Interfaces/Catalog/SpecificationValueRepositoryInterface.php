<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SpecificationValue;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationValueRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return SpecificationValue|PromiseInterface<SpecificationValue>
	 */
	public function get(int $id): SpecificationValue|PromiseInterface;

	public function update(SpecificationValue $specification): null|PromiseInterface;

	public function create(SpecificationValue $specification): null|PromiseInterface;
}
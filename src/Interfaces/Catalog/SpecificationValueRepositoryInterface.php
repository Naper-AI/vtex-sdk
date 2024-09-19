<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SpecificationValue;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationValueRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return null|SpecificationValue|PromiseInterface<SpecificationValue>
	 */
	public function get(int $id): null|SpecificationValue|PromiseInterface;

	public function update(SpecificationValue $specification): null|PromiseInterface;

	public function create(SpecificationValue $specification): null|PromiseInterface;
}